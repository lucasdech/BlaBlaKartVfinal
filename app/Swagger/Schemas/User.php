<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",          
 *     title="User",
 *     properties={
 *         @OA\Property(
 *             property="firstname",
 *             type="string",
 *             description="The first name of the user",
 *             example="John"
 *         ),
 *         @OA\Property(
 *             property="lastname",
 *             type="string",
 *             description="The last name of the user",
 *             example="Doe"
 *         ),
 *         @OA\Property(
 *             property="email",
 *             type="string",
 *             description="The email of the user",
 *             example="john.doe@example.com"
 *         ),
 *         @OA\Property(
 *             property="password",
 *             type="string",
 *             description="The user's password (hashed)",
 *             example="$2y$10$abcdefghijklmnopqrstuv"
 *         ),
 *         @OA\Property(
 *             property="avatar",
 *             type="string",
 *             description="The path to the user's avatar",
 *             example="avatars/1.jpg"
 *         ),
 *         @OA\Property(
 *             property="created_at",
 *             type="string",
 *             format="date-time",
 *             description="The time when the user was created",
 *             example="2020-01-01T00:00:00.000Z"
 *         ),
 *         @OA\Property(
 *             property="updated_at",
 *             type="string",
 *             format="date-time",
 *             description="The time when the user was last updated",
 *             example="2020-01-01T00:00:00.000Z"
 *         )
 *     }
 * )
 */
class User
{
}
