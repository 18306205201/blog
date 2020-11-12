<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($driver)
    {
        try {
            if (app()->environment() == 'local') {
                // 如果是开发环境直接用 id=1 账户直接登陆
                $user = User::find(1);
                Auth::login($user);
                // 用户成功登陆后，从定向到首页
                return redirect($this->redirectTo);
            } else {
                return Socialite::driver($driver)->redirect();
            }
        } catch (\InvalidArgumentException $e) {
            return redirect('/login');
        }

    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($driver, User $mUser)
    {
        $user = Socialite::driver($driver)->user();
        // 判断用户数据是否存在
        $existUser =  User::query()->where('provider', $driver)
            ->where('provider_id', $user->getId())
            ->first();
        if ($existUser == null) {
            $email = $user->getEmail();
            //查询邮件是否被注册过
            $existEmail = User::query()->where('email', $email)->first();
            if ($existEmail == null) {
                // 如果不存在，将数据存入数据库
                $mUser->name = $user->getName();
                $mUser->email = $email;
                $mUser->email_verified_at = date("Y-m-d H:i:s", time());
                $mUser->avatar = $user->getAvatar();
                $mUser->password = '';
                $mUser->provider = $driver;
                $mUser->provider_id = $user->getId();
                $mUser->save();
                $user = $mUser;
            } else {
                if ($existEmail->email == $email) {
                    if ($existEmail->provider == '' || $existEmail->provider_id == '') {
                        $existEmail->provider = $driver;
                        $existEmail->provider_id = $user->getId();
                        $existEmail->save();
                        $user = $existEmail;
                    }
                }
            }

        }
        // 如果存在，手动登陆用户
        Auth::login($user);
        // 用户成功登陆后，从定向到首页
        return redirect($this->redirectTo);
    }


}
