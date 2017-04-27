<?php
namespace App;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser($name_social,ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider($name_social)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $name_social
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}