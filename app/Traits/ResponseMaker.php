<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;

trait ResponseMaker
{
    public function sendResponse($result, $message = '', $pagination = null, $options = null): JsonResponse
    {
        return Response::json(self::makeResponse($result, $message, $pagination, $options));
    }

    public function sendError($error = 'Model not found!', $code = 404): JsonResponse
    {
        return Response::json(
            [
                'success' => false,
                'message' => $error,
            ],
            $code
        );
    }

    public function sendSuccess($message): JsonResponse
    {
        return Response::json(
            [
                'success' => true,
                'message' => $message,
            ]
        );
    }

    public static function makeResponse($data, $message, $pagination = null, $options = null): array
    {
        if ($data instanceof LengthAwarePaginator) {
            $array = $data->toArray();
            $data = $array['data'];
            $pagination['total'] = $array['total'];
        } elseif ($data instanceof Collection) {
            $array = $data->toArray();
            $data = $array;
            $pagination['total'] = count($array);
        } elseif (is_array($data)) {
            $data = $data['data'];
        }

        $response = [
            'success' => true,
            'data' => $data,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        if (!empty($pagination)) {
            $pagesCount = ceil($pagination['total'] / (($pagination['size'] > 0) ? $pagination['size'] : $pagination['total']));
            $response['meta']['pagination'] = [
                'page' => (int)$pagination['page'],
                'size' => (int)$pagination['size'],
                'last_page' => (int)$pagesCount,
                'total' => (int)$pagination['total'],
            ];
        }

        if (null !== $options) {
            $response['options'] = $options;
        }

        return $response;
    }
}