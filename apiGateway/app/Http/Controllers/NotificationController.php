<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class NotificationController extends Controller
{
    use ApiResponser;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        return $this->successResponse($this->notificationService->obtainNotification($request->user()->id));
    }
}
