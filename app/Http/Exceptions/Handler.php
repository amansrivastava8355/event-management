<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return $this->handleApiException($e);
            }
        });
    }

    protected function handleApiException(Throwable $e)
    {
        $statusCode = method_exists($e, 'getStatusCode') 
            ? $e->getStatusCode() 
            : 500;

        $response = [
            'error' => [
                'code' => $statusCode,
                'message' => $e->getMessage(),
            ]
        ];

        if ($e instanceof ValidationException) {
            $response['error']['details'] = $e->errors();
            $statusCode = 422;
        }

        if ($e instanceof ModelNotFoundException) {
            $response['error']['message'] = 'Resource not found';
            $statusCode = 404;
        }

        if (config('app.debug')) {
            $response['debug'] = [
                'exception' => get_class($e),
                'trace' => $e->getTrace()
            ];
        }

        return response()->json($response, $statusCode);
    }
}