<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Inspection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class GradeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => Grade::all()]);
    }

    /**
     * @param $inspectionID
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function getGradesByInspection($inspectionID): JsonResponse
    {
        try {
            $inspection = Inspection::findOrFail($inspectionID);
            return response()->json(['data' => $inspection->grades]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Inspection not found'], 404);
        }
    }

    /**
     * @param $gradeID
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($gradeID): JsonResponse
    {
        try {
            $grade = Grade::findOrFail($gradeID);
            return response()->json(['data' => $grade]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Grade not found'], 404);
        }
    }
}
