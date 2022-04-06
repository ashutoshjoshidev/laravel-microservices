<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class AdminController extends Controller
{
    use ApiResponser;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function approveUser($id)
    {
        return $this->adminService->approveUser($id);
    }

    public function assignTeacher(Request $request, $teacher_id, $student_id)
    {
        return $this->successResponse($this->adminService->assignTeacher($request, $teacher_id, $student_id));
    }
}
