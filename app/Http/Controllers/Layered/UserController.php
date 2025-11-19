<?php

declare(strict_types=1);

namespace App\Http\Controllers\Layered;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

final class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {
    }

    /**
     * 사용자 정보 조회
     * 
     * @param string $id
     * @return View
     */
    public function index(string $id): View
    {
        // 컨트롤러는 서비스 호출만 책임집니다.
        // intval()을 사용하여 문자열 id를 정수형으로 변환합니다.
        $user = $this->userService->getUserById(intval($id));
        
        return view('layered.user.index', ['user' => $user]);
    }

    /**
     * 사용자 등록 폼 표시
     * 
     * @return View
     */
    public function create(): View
    {
        return view('layered.user.register');
    }

    /**
     * 사용자 등록 처리
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // 서비스 계층을 통해 사용자 등록
        $user = $this->userService->registerUser($request->only(['name', 'email', 'password']));

        return view('layered.user.complete', compact('user'));
    }

    /**
     * 로그인 폼 표시
     * 
     * @return View
     */
    public function loginForm(): View
    {
        return view('layered.user.login');
    }

    /**
     * 로그인 처리
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        // 서비스 계층을 통해 사용자 인증
        $user = $this->userService->authenticateUser($credentials['email'], $credentials['password']);

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/layered/user/' . $user->id);
        }

        return back()->withErrors([
            'message' => '메일주소 또는 비밀번호가 올바르지 않습니다.',
        ]);
    }

    /**
     * 로그아웃 처리
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/layered/user/home');
    }
}
