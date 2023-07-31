<?php

namespace App\Http\Controllers;

use App\Models\ComponentType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ComponentTypeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['data' => ComponentType::all()]);
    }

    /**
     * @param $componentType
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($componentType): JsonResponse
    {
        try {
            $componentType = ComponentType::findOrFail($componentType);
            return response()->json(['data' => $componentType]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Component Type not found'], 404);
        }
    }
}
