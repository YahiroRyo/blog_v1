<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Admin;

class AuthController extends Controller
{
    public function reset_auth(Request $request): void {
        $is_remember_token_query = Admin::where('remember_token', $request->cookie('laravel_session'));
        if ($is_remember_token_query->exists()) {
            $admin = $is_remember_token_query->first();
            $admin->fill([
                'is_auth' => false,
            ]);
            $admin->save();
        }
    }
    public function is_auth(Request $request): array {
        $is_remember_token_query = Admin::where('remember_token', $request->cookie('laravel_session'));
        if ($is_remember_token_query->exists()) {
            if ($is_remember_token_query->first()['is_auth']) {
                return ['is_auth' => true];
            }
        }
        return ['is_auth' => false];
    }
    public function auth(Request $request): array {
        // $request->authPass 認証のパスワード
        $auth_pass = $request->authPass;
        $is_remember_token_query = Admin::where('remember_token', $request->cookie('laravel_session'));
        if (config('app.auth_password') == $auth_pass) {
            if ($is_remember_token_query->exists()) {
                $admin = $is_remember_token_query->first();
                $admin->fill([
                    'is_auth' => true,
                ]);
                $admin->save();
            } else {
                $admin = new Admin();
                $admin->fill([
                    'is_auth' => true,
                    'remember_token' => $request->cookie('laravel_session'),
                ]);
                $admin->save();
            }
            return ['is_auth' => true];
        }
        return ['is_auth' => false];
    }
}
