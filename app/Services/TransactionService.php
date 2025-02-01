<?php

namespace App\Services;

use App\Exceptions\TransactionAuthorizationException;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\InvalidTransactionException;
use App\Services\UserServices;
use App\Repositories\TransactionRepository;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class TransactionService
{

    private UserServices $userService;
    private TransactionRepository $transactionRepository;

    private NotificationService $notificationService;

    private $client;
    private $urlAuthorizeTransaction;

    public function __construct(
        UserServices $userService,
        TransactionRepository $transactionRepository,
        NotificationService $notificationService
    ) {
        $this->userService = $userService;
        $this->transactionRepository = $transactionRepository;
        $this->notificationService = $notificationService;
        $this->client = new Client;
        $this->urlAuthorizeTransaction = 'https://util.devi.tools/api/v2/authorize';
    }

    public function createTransaction($payload)
    {
        $sender = $this->userService->findUserById($payload['sender_id']);
        $receiver = $this->userService->findUserById($payload['receiver_id']);

        if(!$this->userService->userCanTransfer($sender)) {
            throw new InvalidTransactionException('Retailers cannot make transactions');
        }

        if(!$this->userService->hasBalance($sender,$payload['amount'])) {
            throw new InsufficientBalanceException(400);
        }

        if (!$this->authorizeTransaction()) {
            throw new TransactionAuthorizationException(422);
        }

        return DB::transaction(function () use ($sender,$receiver,$payload) {
            $this->transactionRepository->withdrawAmount($sender,$payload['amount']);
            $this->transactionRepository->depositAmount($receiver,$payload['amount']);

            $newTransaction = $this->transactionRepository->storeTransaction($payload);

            $this->notificationService->queueTransactionNotifications(
                $sender,
                $receiver,
                $payload['amount']
            );

            return response()->json([
                'transaction' => $newTransaction,
                'message' => 'Transaction completed successfully'
            ],200);
        });
    }

    public function authorizeTransaction()
    {

        try {
            $this->client->request('GET', $this->urlAuthorizeTransaction);
            return true;
        } catch (ClientException $e) {
            return false;
        }
    }

}
