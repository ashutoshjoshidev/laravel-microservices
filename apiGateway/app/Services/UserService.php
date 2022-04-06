<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class UserService
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
        $this->baseUri = config('services.users.base_uri');
        $this->secret = config('services.users.secret');
    }

    /**
     * Logout the user
     */
    public function logOutUser($data)
    {
        return $this->performRequest('GET', '/logout', $data);
    }

    /**
     * Create Student
     */
    public function studentRegistration($data)
    {
        return $this->performRequest('POST', '/student/registration', $data);
    }

    /**
     * Edit a single student data
     */
    public function editStudent($data)
    {
        return $this->performRequest('PUT', "/student/update", $data);
    }

    /**
     * Change an Avatar
     */
    public function changeStudentAvatar($data)
    {
        return $this->performMediaRequest('POST', "/student/changeAvatar", $data);
    }

    /**
     * Create Teacher
     */
    public function teacherRegistration($data)
    {
        return $this->performRequest('POST', '/teacher/registration', $data);
    }
    /**
     * Edit a single teacher data
     */
    public function editTeacher($data)
    {
        return $this->performRequest('PUT', "/teacher/update", $data);
    }

    public function changeTeacherAvatar($data)
    {
        return $this->performMediaRequest('POST', "/teacher/changeAvatar", $data);
    }
}
