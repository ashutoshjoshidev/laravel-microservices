<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'data' => $user->notifications,
        ], 201);
    }
}
