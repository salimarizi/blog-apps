<?php

namespace App\Helper;

use Illuminate\Http\Response;

class ResponseHelper
{
    public static function success($data): Response
    {
        $data = [
            'success' => true,
            'errors' => null,
            'data' => $data
        ];

        return Response($data, 200);
    }

    public static function failed($error, $statusCode): Response
    {
        $data = [
            'success' => false,
            'errors' => $error,
            'data' => null
        ];

        return Response($data, $statusCode);
    }
}
