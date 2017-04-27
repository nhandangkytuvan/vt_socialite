<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
    public function loginFacebook(Request $request){
        return Socialite::driver('facebook')->redirect();   
    }   
    public function loginCallbackFacebook(SocialAccountService $service,Request $request)
    {
        $user = $service->createOrGetUser('facebook',Socialite::driver('facebook')->user());
        auth()->login($user);
        return redirect()->to('/home');
    }

    //

    public function loginGithub(Request $request){
        return Socialite::driver('github')->redirect();
    }
    public function loginCallbackGithub(SocialAccountService $service,Request $request)
    {
        $user = $service->createOrGetUser('github',Socialite::driver('github')->user());
        auth()->login($user);
        return redirect()->to('/home');
    }
}