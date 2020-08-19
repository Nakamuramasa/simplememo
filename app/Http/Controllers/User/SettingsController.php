<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Rules\CheckSamePassword;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', 'string', new MatchOldPassword],
            'password' => ['required', 'string', 'min:8', 'confirmed', new CheckSamePassword]
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['message' => 'パスワードを更新しました。'], 200);
    }
}
