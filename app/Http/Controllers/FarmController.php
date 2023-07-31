<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class FarmController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => Farm::all()]);
    }

    /**
     * @param $farmID
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($farmID): JsonResponse
    {
        try {
            $farm = Farm::findOrFail($farmID);
            return response()->json(['data' => $farm]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Farm not found'], 404);
        }
    }
}
