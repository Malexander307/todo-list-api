<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function successResponse(mixed $data, string $message = 'success',int $status = 200): Response
    {
        return response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function errorResponse(mixed $data, string $message = 'success',int $status = 500): Response
    {
        return response([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
