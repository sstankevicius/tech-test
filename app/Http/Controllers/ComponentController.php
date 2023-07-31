<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Turbine;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ComponentController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => Component::all()]);
    }

    /**
     * @param $turbineID
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function getComponentsByTurbine($turbineID): JsonResponse
    {
        try {
            $turbine = Turbine::findOrFail($turbineID);
            return response()->json(['data' => $turbine->components]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Turbine not found'], 404);
        }
    }
}
