<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use App\Traits\VerifiesJwts;
use Illuminate\Support\Facades\Log;

class TokenController extends Controller
{
    use VerifiesJwts;

    public function __invoke(Request $request)
    {
        $jwt = $this->verifyJwt($request->input('client_assertion'));

        $tool = $this->getTool($jwt);

        $token = $tool->createToken($jwt['body']['jti']);

        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration') * 60,
            'scope' => $request->input('scope')
        ]);
    }

    private function getTool(array $jwt): Tool
    {
        return Tool::findOrFail($jwt['body']['iss']);
    }

    private function getJwksUrl(array $jwt): string
    {
        return $this->getTool($jwt)->jwks_url;
    }
}
