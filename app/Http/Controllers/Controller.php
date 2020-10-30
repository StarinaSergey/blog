<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Test Shop API",
 *      description="Description of API for the shop module (order form, checkout, client account)",
 *      @OA\Contact(
 *          email="starinasergey@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *


 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication endpoints (login, register, reset password, etc.)"
 * )

 * @OA\Tag(
 *     name="ConfigData",
 *     description="Site data needed for the frontend (project types, prices, subjects, etc.)"
 * )

 * @OA\Tag(
 *     name="Orders",
 *     description="Orders"
 * )

 * @OA\Tag(
 *     name="OrderMessages",
 *     description="Order messages"
 * )

 * @OA\Tag(
 *     name="Tickets",
 *     description="Support tickets"
 * )

 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
