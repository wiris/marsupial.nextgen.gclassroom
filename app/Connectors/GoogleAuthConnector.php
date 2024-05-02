<?php

namespace App\Connectors;

use App\Models\User;
use Google\Service\Oauth2\Userinfo;
use Google_Client;

class GoogleAuthConnector
{
    /**
     * Gets a google client
     *
     * @return Google_Client
     */
    protected function getClient(): Google_Client
    {
        $client = new Google_Client();

        /*
       Due to some discrepancies between the local webserver clock and the Google Auth Server's clock, it might
       be the case that setting up a leeway is required:
       https://stackoverflow.com/questions/69600358/php-session-discrepancy-between-development-localhost-and-hosted-service
       */
        $jwt = new \Firebase\JWT\JWT;
        $jwt::$leeway += 1000;

        $client = new Google_Client([
            'jwt' => $jwt,
            'client_id' => config('google.client_id'),
            'client_secret' => config('google.client_secret'),
        ]);
        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);
        $client->setRedirectUri(route('login.google.callback'));
        $client->setScopes(config('google.scopes'));
        $client->setPrompt('consent');
        return $client;
    }


    /**
     * Returns a Google client that is logged for the given user and
     * is authorized to access the user's API.
     *
     * @return Google_Client
     */
    protected function getAuthorizedClient(User $user): Google_Client
    {
        /**
         * Strip slashes from the access token json
         */
        $accessTokenJson = stripslashes($user->google_access_token_json);

        /**
         * Get client and set access token
         */
        $client = $this->getClient();
        $client->setAccessToken($accessTokenJson);

        /**
         * Handle refresh of expired token
         */
        if ($client->isAccessTokenExpired()) {
            // Fetch new access token
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $client->setAccessToken($client->getAccessToken());

            // Save new access token
            $user->google_access_token_json = json_encode($client->getAccessToken());
            $user->save();
        }

        /**
         * Return authorized client
         */
        return $client;
    }

    public function revokeUserAccess(User $user)
    {
        $client = $this->getAuthorizedClient($user);
        $client->revokeToken();
        $user->google_access_token_json = null;
        $user->save();
    }


    public function getOauthUrl()
    {
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        return $authUrl;
    }

    public function accessTokenFromAuthCode(string $authCode): array
    {
        $client = $this->getClient();
        return $client->fetchAccessTokenWithAuthCode($authCode);
    }

    public function getUserInfo(array $accessToken): Userinfo
    {
        $client = $this->getClient();
        $client->setAccessToken($accessToken);
        $service = new \Google\Service\Oauth2($client);
        return $service->userinfo->get();
    }
}
