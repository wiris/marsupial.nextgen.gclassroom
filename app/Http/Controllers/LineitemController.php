<?php

namespace App\Http\Controllers;

use App\Connectors\GoogleClassroomConnector;
use App\Models\Lineitem;
use App\Models\Material;
use Illuminate\Http\Request;

class LineitemController extends Controller
{

    public function __construct(
        private readonly GoogleClassroomConnector $googleClassroomConnector
    ) {
    }

    public function index(Request $request, Material $material)
    {
        return response()->noContent();
    }

    public function show(Request $request, Material $material, Lineitem $lineitem)
    {
        return response()->noContent();
    }

    public function score(Request $request, Material $material, Lineitem $lineitem)
    {
        $lineitem->score_given = $request->input('scoreGiven');
        $lineitem->score_maximum = $request->input('scoreMaximum');
        $lineitem->activity_progress = $request->input('activityProgress') ?? 'Completed';
        $lineitem->grading_progress = $request->input('gradingProgress') ?? 'FullyGraded';
        $lineitem->save();

        $this->googleClassroomConnector->putGrade($lineitem);

        return response()->noContent();
    }
}
