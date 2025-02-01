<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository
{

    protected $modelClass = Notification::class;

    public function storeNotification($notificationData)
    {
        $this->model()->create($notificationData);
    }
}
