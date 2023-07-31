<?php

namespace App\Http\Controllers;

use App\Models\GradeType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class GradeTypeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => GradeType::all()]);
    }

    /**
     * @param $gradeType
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($gradeType): JsonResponse
    {
        try {
            $gradeType = GradeType::findOrFail($gradeType);
            return response()->json(['data' => $gradeType]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Grade Type not found'], 404);
        }
    }
}
