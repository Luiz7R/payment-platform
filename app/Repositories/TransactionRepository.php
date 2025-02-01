<?php

namespace App\Repositories;

use App\Models\Transactions;
use App\Repositories\BaseRepository;

class TransactionRepository extends BaseRepository
{

    protected $modelClass = Transactions::class;

    public function storeTransaction($transactionPayload)
    {
        return $this->model()->create($transactionPayload);
    }

    public function withdrawAmount($sender,$amount)
    {
        $sender->setBalance($sender->balance - $amount);
        $sender->save();
    }

    public function depositAmount($receiver,$amount)
    {
        $receiver->setBalance($receiver->balance + $amount);
        $receiver->save();
    }
}
