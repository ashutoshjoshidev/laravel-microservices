<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Traits\ApiResponser;

class StudentController extends Controller
{
    use ApiResponser;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registration(Request $request)
    {
        return  $this->successResponse($this->userService->studentRegistration($request->all()));
    }

    public function update(Request $request)
    {
        $request->request->add(['student_id' => $request->user()->id]);
        return $this->successResponse($this->userService->editStudent($request->all()));
    }

    public function changeAvatar(Request $request)
    {
        $request->request->add(['student_id' => $request->user()->id]);
        return $this->successResponse($this->userService->changeStudentAvatar($request->all()));
    }
}
