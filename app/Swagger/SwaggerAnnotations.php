<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Car Covoit API",
 *     version="1.0.0",
 *     description="API documentation for Car Covoit"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="Sanctum",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Enter token in format (Bearer <token>)"
 * )
 */
class SwaggerAnnotations
{
    
}
