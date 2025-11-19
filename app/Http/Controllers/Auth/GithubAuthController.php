<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    /**
     * 사용자를 깃허브 인증 페이지로 리디렉션합니다.
     */
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * 깃허브에서 사용자 정보를 받아 처리합니다.
     */
    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();

        // 먼저 github_id로 사용자를 찾습니다
        $user = User::where('github_id', $githubUser->id)->first();

        // github_id로 찾지 못했고, 이메일이 제공된 경우 이메일로 찾습니다
        if (!$user && $githubUser->email) {
            $user = User::where('email', $githubUser->email)->first();
        }

        // 사용자가 있으면 GitHub 정보를 업데이트하고, 없으면 새로 생성합니다
        if ($user) {
            $user->update([
                'github_id' => $githubUser->id,
                'name' => $githubUser->name ?? $user->name,
                'github_token' => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
            ]);
        } else {
            // 새 사용자 생성 (이메일이 없을 수도 있음)
            $user = User::create([
                'github_id' => $githubUser->id,
                'name' => $githubUser->name ?? $githubUser->nickname,
                'email' => $githubUser->email,
                'github_token' => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
            ]);
        }

        Auth::login($user);

        return redirect('/dashboard');
    }
}
