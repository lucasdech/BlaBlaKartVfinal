<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Trip",
 *     type="object",
 *     title="Trip",
 *     required={"starting_point", "ending_point", "starting_at", "available_seats", "price"},
 *     @OA\Property(property="id", type="integer", readOnly=true, description="Trip ID"),
 *     @OA\Property(property="starting_point", type="string", description="Starting point of the trip"),
 *     @OA\Property(property="ending_point", type="string", description="Ending point of the trip"),
 *     @OA\Property(property="starting_at", type="string", format="date", description="Starting date of the trip"),
 *     @OA\Property(property="available_seats", type="integer", description="Number of available seats"),
 *     @OA\Property(property="price", type="number", format="float", description="Price of the trip"),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Update timestamp")
 * )
 */
class Trip
{
}
