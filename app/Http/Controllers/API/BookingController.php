<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\TripBooked;
use App\Notifications\TripBookingConfirmation;

class BookingController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/booking",
     *     summary="Book a trip for the authenticated user",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"trip_id"},
     *             @OA\Property(property="trip_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trip booked successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="trip", ref="#/components/schemas/Trip")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trip not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or No available seats"
     *     )
     * )
     */
    public function bookTrip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);

        $user = $request->user();
        $trip = Trip::findOrFail($request->trip_id);

        if (in_array($trip->id, $user->trips ?? [])) {
            return response()->json(['message' => 'You have already booked this trip'], 422);
        }

        if ($trip->available_seats <= 0) {
            return response()->json(['message' => 'No available seats for this trip'], 422);
        }

        // Use a database transaction to ensure data integrity
        DB::beginTransaction();

        try {
            $trip->available_seats -= 1;
            $trip->save();

            $user->trips = array_merge($user->trips ?? [], [$trip->id]);
            $user->save();

            // Send notifications
            $trip->user->notify(new TripBooked($trip, $user));
            $user->notify(new TripBookingConfirmation($trip));

            return response()->json([
                'message' => 'Trip booked successfully',
                'user' => $user,
                'trip' => $trip
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while booking the trip'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/booking/{trip_id}",
     *     summary="Cancel a trip booking for the authenticated user",
     *     tags={"Bookings"},
     *     @OA\Parameter(
     *         name="trip_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Booking cancelled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="trip", ref="#/components/schemas/Trip")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trip not found or not booked"
     *     )
     * )
     */
    public function cancelBooking(Request $request, $trip_id)
    {
        $user = $request->user();
        $trip = Trip::findOrFail($trip_id);

        if (!in_array($trip->id, $user->trips ?? [])) {
            return response()->json(['message' => 'You have not booked this trip'], 404);
        }

        DB::beginTransaction();

        try {
            $trip->available_seats += 1;
            $trip->save();

            // Remove the trip from the user's booked trips
            $user->trips = array_values(array_diff($user->trips, [$trip->id]));
            $user->save();

            DB::commit();

            return response()->json([
                'message' => 'Booking cancelled successfully',
                'user' => $user,
                'trip' => $trip
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while cancelling the booking'], 500);
        }
    }
}
