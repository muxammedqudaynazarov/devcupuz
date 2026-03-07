<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Ilzrv\LaravelSteamAuth\Exceptions\Authentication\SteamResponseNotValidAuthenticationException;
use Ilzrv\LaravelSteamAuth\Exceptions\Validation\ValidationException;
use Ilzrv\LaravelSteamAuth\SteamAuthenticator;
use Ilzrv\LaravelSteamAuth\SteamUserDto;

final class SteamAuthController extends Controller
{
    public function __invoke(
        Request $request,
        Redirector $redirector,
        Client $client,
        HttpFactory $httpFactory,
        AuthManager $authManager,
    ): RedirectResponse {
        $steamAuthenticator = new SteamAuthenticator(
            new Uri($request->getUri()),
            $client,
            $httpFactory
        );

        try {
            // Agar callback bo‘lsa – validate qiladi
            $steamAuthenticator->auth();
        } catch (ValidationException | SteamResponseNotValidAuthenticationException) {
            // Birinchi kirishda – Steam’ga redirect qiladi
            return $redirector->to(
                $steamAuthenticator->buildAuthUrl()
            );
        }

        // Steam’dan kelgan user
        $steamUser = $steamAuthenticator->getSteamUser();

        // Login
        $authManager->login(
            $this->firstOrCreate($steamUser),
            true
        );

        return $redirector->to('/home');
    }

    private function firstOrCreate(SteamUserDto $steamUser): User
    {
        return User::updateOrCreate(
            ['steam_id' => $steamUser->getSteamId()],
            [
                'name'         => $steamUser->getPersonaName(),
                'avatar'       => $steamUser->getAvatarFull(),
                'player_level' => $steamUser->getPlayerLevel(),
            ]
        );
    }
}
