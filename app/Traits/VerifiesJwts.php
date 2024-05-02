<?php

namespace App\Traits;

use Exception;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;

trait VerifiesJwts
{
    public function verifyJwt(string $jwt): array
    {
        $jwt_parts = explode('.', $jwt);

        $decodedJwt = [];
        // Decode JWT headers.
        $decodedJwt['header'] = json_decode(JWT::urlsafeB64Decode($jwt_parts[0]), true);
        // Decode JWT Body.
        $decodedJwt['body'] = json_decode(JWT::urlsafeB64Decode($jwt_parts[1]), true);

        // Check signature
        JWT::$leeway = 60;
        JWT::decode($jwt, $this->getPublicKey($this->getJwksUrl($decodedJwt), $decodedJwt['header']['kid']));

        return $decodedJwt;
    }

    abstract private function getJwksUrl(array $decodedJwt): string;

    private function getPublicKey(string $jwksUrl, string $kid)
    {
        // Download key set
        $jwks = json_decode(file_get_contents($jwksUrl), true);

        if (empty($jwks)) {
            // Failed to fetch public keyset from URL.
            abort(500, 'Failed to fetch JWT');
        }

        // Find key used to sign the JWT (matches the KID in the header)
        foreach ($jwks['keys'] as $key) {
            if ($key['kid'] == $kid) {
                try {
                    $keySet = JWK::parseKeySet([
                        'keys' => [$key],
                    ]);
                } catch (Exception $e) {
                    // Do nothing
                }

                if (isset($keySet[$key['kid']])) {
                    return $keySet[$key['kid']];
                }
            }
        }
    }
}
