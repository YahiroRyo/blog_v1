<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Admin;

class AuthController extends Controller
{
    public function reset_auth(Request $request): void {
        $request->session()->put('is_auth', false);
    }
    public function is_auth(Request $request): array {
        if ($request->session()->get('is_auth') !== null) {
            return ['is_auth' => $request->session()->get('is_auth')];
        } else {
            $request->session()->put('is_auth', false);
            return ['is_auth' => false];
        }
    }
    public function auth(Request $request): array {
        // $request->authPass 認証のパスワード
        $auth_pass = $request->authPass;
        if (config('app.auth_password') == $auth_pass) {
            $request->session()->put('is_auth', true);
            return ['is_auth' => true];
        }
        return ['is_auth' => false];
    }
}
