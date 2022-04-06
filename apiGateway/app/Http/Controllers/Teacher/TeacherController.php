<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Traits\ApiResponser;

class TeacherController extends Controller
{
    use ApiResponser;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registration(Request $request)
    {
        return  $this->successResponse($this->userService->teacherRegistration($request->all()));
    }

    public function update(Request $request)
    {
        $request->request->add(['teacher_id' => $request->user()->id]);
        return $this->successResponse($this->userService->editTeacher($request->all()));
    }

    public function changeAvatar(Request $request)
    {
        $request->request->add(['teacher_id' => $request->user()->id]);
        return $this->successResponse($this->userService->changeTeacherAvatar($request->all()));
    }
}
