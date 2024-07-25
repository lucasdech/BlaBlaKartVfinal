<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use DateTime;
use Illuminate\Http\Request;


class TripController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/trips",
     *     summary="Get list of trips",
     *     tags={"Trips"},
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         description="Starting point of the trip",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="end",
     *         in="query",
     *         description="Ending point of the trip",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Starting date of the trip",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Trip"))
     *     ),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/trips",
     *     summary="Create a new trip",
     *     tags={"Trips"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Trip created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
     *     ),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/trips/{trip}",
     *     summary="Get a trip by ID",
     *     tags={"Trips"},
     *     @OA\Parameter(
     *         name="trip",
     *         in="path",
     *         description="Trip ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
     *     ),
     *     @OA\Response(response=404, description="Trip not found")
     * )
     */
    public function show(Trip $trip)
    {
        return response()->json($trip);
    }

    /**
     * @OA\Put(
     *     path="/api/trips/{trip}",
     *     summary="Update an existing trip",
     *     tags={"Trips"},
     *     @OA\Parameter(
     *         name="trip",
     *         in="path",
     *         description="Trip ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trip updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Trip")
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Trip not found")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/trips/{trip}",
     *     summary="Delete a trip",
     *     tags={"Trips"},
     *     @OA\Parameter(
     *         name="trip",
     *         in="path",
     *         description="Trip ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Trip deleted successfully"
     *     ),
     *     @OA\Response(response=404, description="Trip not found")
     * )
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/trips",
     *     operationId="searchTrips",
     *     tags={"Trips"},
     *     summary="Search trips",
     *     description="Search for trips based on start, end, and date parameters",
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         description="Starting point of the trip",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="end",
     *         in="query",
     *         description="Ending point of the trip",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Starting date of the trip",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Trip")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    

    // private function isValidDate($date)
    // {
    //     $d = DateTime::createFromFormat('Y-m-d', $date);
    //     return $d && $d->format('Y-m-d') === $date;
    // }
}
