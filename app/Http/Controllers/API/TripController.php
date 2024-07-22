<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::query();

        if ($request->has('start')) {
            $query->where('starting_point', 'like', '%' . $request->start . '%');
        }

        if ($request->has('end')) {
            $query->where('ending_point', 'like', '%' . $request->end . '%');
        }

        if ($request->has('date')) {
            $query->whereDate('starting_at', $request->date);
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'starting_point' => 'required|string',
            'ending_point' => 'required|string',
            'starting_at' => 'required|date',
            'available_seats' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $trip = $request->user()->trips()->create($validated);

        return response()->json($trip, 201);
    }

    public function show(Trip $trip)
    {
        return response()->json($trip);
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'starting_point' => 'sometimes|string',
            'ending_point' => 'sometimes|string',
            'starting_at' => 'sometimes|date',
            'available_seats' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $trip->update($validated);

        return response()->json($trip);
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return response()->json(null, 204);
    }
}