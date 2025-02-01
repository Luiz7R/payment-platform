<?php

namespace App\Services;

use App\Exceptions\NotificationException;
use App\Models\User;
use App\Repositories\NotificationRepository;
use App\Jobs\SendNotificationJob;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

class NotificationService
{

    private $client;
    private $urlPostNotification;

    private $notificationRepository;

    public function __construct(
        NotificationRepository $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->client = new Client;
        $this->urlPostNotification = 'https://util.devi.tools/api/v1/notify';
    }

    public function queueTransactionNotifications($sender, $receiver, $amount)
    {
        $senderMessage = 'Transaction Successfully Completed for the Amount of: ' . $amount;
        SendNotificationJob::dispatch($sender, $senderMessage);

        $receiverMessage = 'Transaction Received Successfully for the Amount of: ' . $amount;
        SendNotificationJob::dispatch($receiver, $receiverMessage);
    }

    public function sendNotification(User $user, string $message)
    {
        try {
            $response = $this->client->request('POST', $this->urlPostNotification, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'message' => $message
                ]
            ]);

            if ($response->getStatusCode() != 204) {
                throw new NotificationException("Error sending notification");
            }

            $this->notificationRepository->storeNotification([
                'message' => $message,
                'email' => $user->email
            ]);

            print("Notification sent to {$user->firstName} {$user->lastName} in the E-mail
                {$user->email}
            ");

            return true;
        } catch (ServerException $e) {
            throw new NotificationException('Notification Service Not Available');
        }

    }

}
