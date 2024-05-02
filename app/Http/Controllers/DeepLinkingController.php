<?php

namespace App\Http\Controllers;

use App\Connectors\GoogleClassroomConnector;
use App\Enums\LaunchType;
use App\Models\LtiLaunch;
use App\Models\Tool;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Traits\VerifiesJwts;

class DeepLinkingController extends Controller
{
    use VerifiesJwts;

    public function deepLinkingInit(Request $request)
    {
        $toolId = $request->query('tool');
        $courseId = $request->query('course');

        $tool = Tool::findOrFail($toolId);

        if (!$courseId) {
            abort(400, 'Missing course id');
        }

        $ltiLaunch = new LtiLaunch();
        $ltiLaunch->user_id = auth()->user()->id;
        $ltiLaunch->tool_deployment_id = $tool->deployments()->first()->id;
        $ltiLaunch->launch_type = LaunchType::DEEP_LINK;
        $ltiLaunch->course_id = $courseId;
        $ltiLaunch->save();

        return Inertia::render(
            'LtiLaunch',
            [
                'clientId' => $tool->id,
                'ltiLaunchId' => $ltiLaunch->id,
                'iss' => config('app.url'),
                'initiationUrl' => $tool->oidc_initiation_url,
                'targetLinkUri' => $tool->deep_link_url ?? $tool->target_link_uri,
            ]
        );
    }

    public function deepLinkingReturn(Request $request, GoogleClassroomConnector $gc)
    {

        $jwt = $this->verifyJwt($request->input('JWT'));
        $ltiLaunch = $this->getLtiLaunch($jwt);
        $deployment = $ltiLaunch->toolDeployment;

        $contentItem = $jwt['body']['https://purl.imsglobal.org/spec/lti-dl/claim/content_items'][0];

        $material = $deployment->materials()->create([
            'title' => $contentItem['title'],
            'description' => $contentItem['text'] ?? null,
            'custom_claim' => $contentItem['custom'] ? json_encode($contentItem['custom']) : null,
            'course_id' => $ltiLaunch->course_id,
            'user_id' => $ltiLaunch->user_id,
            'coursework_id' => ''
        ]);

        if (isset($contentItem['lineItem'])) {
            $material->gradable = true;
            $material->score_maximum = $contentItem['lineItem']['scoreMaximum'] ?? 1;
            $material->save();
        }

        $courseworkId = $gc->share($ltiLaunch->user, $material);

        $material->coursework_id = $courseworkId;
        $material->save();

        return to_route('lti.dl.success');
    }

    private function getLtiLaunch(array $jwt): LtiLaunch
    {
        return LtiLaunch::findOrFail($jwt['body']['https://purl.imsglobal.org/spec/lti-dl/claim/data']);
    }

    private function getJwksUrl(array $jwt): string
    {
        return $this->getLtiLaunch($jwt)->toolDeployment->tool->jwks_url;
    }

    public function deepLinkingSuccess()
    {
        return Inertia::render('DeepLinkingSuccess');
    }
}
