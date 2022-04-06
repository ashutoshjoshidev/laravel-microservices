<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\UserApproveNotification;
use App\Traits\ApiResponser;
use App\Traits\ConsumeExternalService;
use Illuminate\Support\Facades\Notification;

class AdminService
{
    use ApiResponser;
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
        $this->baseUri = config('services.users.base_uri');
        $this->secret = config('services.users.secret');
    }

    public function approveUser($id)
    {
        $user = User::findOrfail($id);
        $user->status = 1;
        $user->save();
        if ($user->status == 1) {
            Notification::send($user, new UserApproveNotification($user));
            return $this->successResponse([
                'message' => 'User successfully approved',
                'user' => $user,
            ]);
        } else {
            return $this->errorMessage([
                'errors' => 'Unauthorized! Account is unapproved.',
                'user' => $user,
            ], 400);
        }
    }

    public function assignTeacher($data, $teacher_id, $student_id)
    {
        return $this->performRequest('GET', "/admin/assignTeacher/{$teacher_id}/{$student_id}", $data);
    }
}
