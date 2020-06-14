<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInPost;
use App\User;
use Illuminate\Support\Facades\Hash;

class SignInController extends Controller
{
    public function index()
    {
        return view('signin');
    }

    public function store(SignInPost $request)
    {
        // Validasi data
        $data = $request->validated();

        // Cek apakah user ada
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            // Cek apakah password sudah benar
            if (Hash::check($data['password'], $user->password)) {

            }
        }
    }
}
