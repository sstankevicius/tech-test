<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\Turbine;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class InspectionController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => Inspection::all()]);
    }

    /**
     * @param $turbineID
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function getInspectionsByTurbine($turbineID): JsonResponse
    {
        try {
            $turbine = Turbine::findOrFail($turbineID);
            return response()->json(['data' => $turbine->inspections]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Turbine not found'], 404);
        }
    }

    /**
     * @param $inspectionID
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($inspectionID): JsonResponse
    {
        try {
            $inspection = Inspection::findOrFail($inspectionID);
            return response()->json(['data' => $inspection]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Inspection not found'], 404);
        }
    }
}
