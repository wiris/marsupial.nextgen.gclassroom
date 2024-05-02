<?php

namespace App\Http\Controllers;

use App\Connectors\GoogleClassroomConnector;
use App\Enums\LaunchType;
use App\Models\LtiLaunch;
use App\Models\Material;
use App\Models\Tool;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GoogleClassroomConnector $gc, Request $request)
    {
        if (auth()->user()->role == "student") {
            return Inertia::render(
                'Forbidden'
            );
        }

        $courseId = $request->query('course');

        if ($courseId) {
            return Inertia::render(
                'Materials',
                [
                    'materials' => Material::with('toolDeployment.tool')->where('course_id', '=', $courseId)->get(),
                    'course' => [
                        'id' => $courseId,
                        'name' => $gc->getCourseName(auth()->user(), $courseId)
                    ],
                ]
            );
        }

        return Inertia::render(
            'ChooseCourse',
            [
                'courses' => $gc->getCourses(auth()->user(), true),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (auth()->user()->role == "student") {
            return Inertia::render(
                'Forbidden'
            );
        }

        $courseId = $request->query('course');

        if (!$courseId) {
            abort(400, 'Missing course id');
        }

        return Inertia::render(
            'ChooseTool',
            [
                'tools' => Tool::all(),
                'courseId' => $courseId,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(GoogleClassroomConnector $gc, Material $material)
    {

        $user = auth()->user();

        if ($gc->isTeacherOfCourse($user, $material->course_id)) {
            if ($user->role == 'student') {
                $user->role = 'teacher';
            }
        } else if (!$gc->isStudentOfCourse($user, $material->course_id) && $user->role != 'admin') {
            return Inertia::render(
                'Forbidden'
            );
        }

        $ltiLaunch = new LtiLaunch();
        $ltiLaunch->material_id = $material->id;
        $ltiLaunch->user_id = $user->id;
        $ltiLaunch->tool_deployment_id = $material->toolDeployment->id;
        $ltiLaunch->launch_type = LaunchType::RESOURCE_LINK;

        $ltiLaunch->save();

        $tool = $material->toolDeployment->tool;

        return Inertia::render(
            'LtiLaunch',
            [
                'clientId' => $tool->id,
                'ltiLaunchId' => $ltiLaunch->id,
                'iss' => config('app.url'),
                'initiationUrl' => $tool->oidc_initiation_url,
                'targetLinkUri' => $tool->target_link_uri,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        if (auth()->user()->role == "student") {
            return Inertia::render(
                'Forbidden'
            );
        }

        $material->delete();
        return to_route('materials.index');
    }
}
