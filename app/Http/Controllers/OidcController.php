<?php

namespace App\Http\Controllers;

use App\Connectors\GoogleClassroomConnector;
use App\Enums\LaunchType;
use App\Models\Lineitem;
use App\Models\LtiLaunch;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\RSA;

class OidcController extends Controller
{
    private function privateKeyId()
    {
        return "marsupial_0";
    }

    public function jwks(Request $request)
    {
        return response()->json(['keys' => $this->getPublicJwks()]);
    }

    private function getPublicJwks()
    {
        $keys = [
            $this->privateKeyId() => $this->getPrivateKey()
        ];

        $jwks = [];
        foreach ($keys as $kid => $private_key) {
            $key = RSA::load($private_key, config('oidc.passphrase'));
            $jwk = json_decode($key->getPublicKey()->toString('JWK'), true);
            $jwks[] = array_merge($jwk['keys'][0], [
                'alg' => 'RS256',
                'use' => 'sig',
                'kid' => $kid,
            ]);
        }
        return $jwks;
    }

    private function getPrivateKey()
    {
        return Storage::disk('local')->get(config('oidc.location'));
    }

    public function auth(GoogleClassroomConnector $gc, Request $request)
    {
        $loginHint = $request->input('login_hint');

        $launch = LtiLaunch::findOrFail($loginHint);

        $user = $launch->user;

        $messageJwt = [
            "iss" => config('app.url'),
            "aud" => [$launch->toolDeployment->tool->id],
            "sub" => $launch->user->id,
            "exp" => time() + 600,
            "iat" => time(),
            "name" => $launch->user->name,
            "email" => $launch->user->email,
            "nonce" => $request->input("nonce"),

            "https://purl.imsglobal.org/spec/lti/claim/deployment_id" => $launch->toolDeployment->id,
            "https://purl.imsglobal.org/spec/lti/claim/message_type" => $launch->launch_type,
            "https://purl.imsglobal.org/spec/lti/claim/version" => "1.3.0",
            "https://purl.imsglobal.org/spec/lti/claim/target_link_uri" => $launch->toolDeployment->tool->target_link_uri,
            "https://purl.imsglobal.org/spec/lti/claim/roles" => [
                match ($user->role) {
                    'admin' => "http://purl.imsglobal.org/vocab/lis/v2/membership#Administrator",
                    'teacher' => "http://purl.imsglobal.org/vocab/lis/v2/membership#Faculty",
                    default => "http://purl.imsglobal.org/vocab/lis/v2/membership#Student"
                }
            ],
        ];

        if ($launch->launch_type == LaunchType::DEEP_LINK) {
            $messageJwt["https://purl.imsglobal.org/spec/lti/claim/launch_presentation"] = [
                "document_target" => "iframe",
                "height" => 1200,
                "width" => 1200
            ];
            $messageJwt["https://purl.imsglobal.org/spec/lti-dl/claim/deep_linking_settings"] = [
                "deep_link_return_url" => route('lti.dl', ['deployment' => $launch->toolDeployment->id]),
                "accept_types" => ["ltiResourceLink"],
                "accept_presentation_document_targets" => ["iframe"],
                "data" => $launch->id
            ];
            $messageJwt["https://purl.imsglobal.org/spec/lti/claim/context"] = [
                "id" => $launch->course_id,
                "title" => $gc->getCourseName($user, $launch->course_id),
                "type" => ["CourseOffering"]
            ];
        } else if ($launch->launch_type == LaunchType::RESOURCE_LINK) {
            $messageJwt["https://purl.imsglobal.org/spec/lti/claim/resource_link"] = [
                "id" => $launch->material->id,
            ];
            $messageJwt["https://purl.imsglobal.org/spec/lti/claim/custom"] = json_decode($launch->material->custom_claim);
            if ($launch->material->gradable) {
                $lineitem =
                    $launch->material->lineitems()->whereBelongsTo($user)->get()?->first() ??
                    $launch->material->lineitems()->create(['user_id' => $launch->user->id]);

                $messageJwt['https://purl.imsglobal.org/spec/lti-ags/claim/endpoint'] = [
                    'scope' => [
                        "https://purl.imsglobal.org/spec/lti-ags/scope/score"
                    ],
                    'lineitems' => route('materials.lineitems.index', ['material' => $launch->material->id]),
                    'lineitem' => route('materials.lineitems.show', ['material' => $launch->material->id, 'lineitem' => $lineitem->id]),
                ];
            }
        } else {
            abort(400);
        }

        $pk = openssl_pkey_get_private($this->getPrivateKey(), config('oidc.passphrase'));

        $jwt = JWT::encode(
            $messageJwt,
            $pk,
            'RS256',
            $this->privateKeyId()
        );

        return view('oidc_auth', [
            'redirect_uri' => $request->input('redirect_uri'),
            'state' => $request->input('state'),
            'jwt' => $jwt
        ]);
    }
}
