<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('layouts.account');
    }

    /**
     * Change user password
     *
     * @param  mixed $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $fields = $request->validate([
            'old_password' => ['required', 'string', Password::defaults()],
            'new_password' => ['required', 'string', Password::defaults()],
            'new_password_confirmation' => ['required', 'string', Password::defaults()],
        ]);

        $user = User::where('email', $request->user()->email)->first();

        if (!$user || !Hash::check($fields['old_password'], $user->password)) {
            return response()->json([
                'error' => 'Old password is not correct'
            ], 401);
        } elseif ($fields['new_password'] != $fields['new_password_confirmation']) {
            return response()->json([
                'error' => 'New passwords do not match'
            ], 401);
        } else {
                $user->password = Hash::make($fields['new_password']);
                if ($user->save()) {
                    return response()->json([
                        'message' => 'Your password has been changed'
                    ]);
                }
                return response()->json([
                    'message' => 'Error while connecting to database'
                ]);
        }
    }
}
