<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class NotificationService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume authors service
     * @var string
     */
    public $baseUri;

    /**
     * Authorization secret to pass to author api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.notification.base_uri');
        $this->secret = config('services.notification.secret');
    }

    /**
     * Logout the user
     */
    public function obtainNotification($id)
    {
        return $this->performRequest('GET', "/notifications/{$id}");
    }
}
