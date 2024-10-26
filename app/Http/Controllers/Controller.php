<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController {
    public function afterMiddleware(array $array) : JsonResponse {
        unset($array['from']);
        return response()->json($array,200);
    }
}
