<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Turbine;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class TurbineController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => Turbine::all()]);
    }

    /**
     * @param $farmID
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function getTurbinesByFarm($farmID): JsonResponse
    {
        try {
            $farm = Farm::findOrFail($farmID);
            return response()->json(['data' => $farm->turbines]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Farm not found'], 404);
        }
    }

    /**
     * @param $turbineID
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($turbineID): JsonResponse
    {
        try {
            $turbine = Turbine::findOrFail($turbineID);
            return response()->json(['data' => $turbine]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Turbine not found'], 404);
        }
    }
}
