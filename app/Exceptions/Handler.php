<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use kamermans\OAuth2\Exception\AccessTokenRequestException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $feedback = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'class' => $exception . get_class(),
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            // 'trace' => $exception->getTraceAsString(),
            // 'exception' => $exception->__toString(),
        ];

        if ($this->isHttpException($exception)) {
            $feedback['status'] = $exception->getStatusCode();
        }

        Log::error('Exception', $feedback);

        if ($exception instanceof AccessTokenRequestException) {
            Auth::logout();
            // $feedback['body'] = json_decode($exception->getResponse()->getBody(), true);

            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $exception);
    }
}
