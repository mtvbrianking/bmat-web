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
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'class' => get_class($exception),
            // 'trace' => $exception->getTraceAsString(),
            // 'exception' => $exception->__toString(),
        ];

        if ($this->isHttpException($exception)) {
            $feedback['status'] = $exception->getStatusCode();
        }

        Log::error('Exception', $feedback);

        if ($exception instanceof AccessTokenRequestException) {
            Auth::logout();
            Log::error(sprintf(
                "%s:%d %s (%d) [%s]\n",
                    $exception->getFile(),
                    $exception->getLine(),
                    $exception->getMessage(),
                    $exception->getCode(),
                    get_class($exception)
                )
            );

            $guzzle_request_exception = $exception->getPrevious();

            $api_response = json_decode($guzzle_request_exception->getResponse()->getBody(), true);

            $feedback['body'] = $api_response;

            switch ($api_response['error']) {
                case 'invalid_client':
                    // Client App: wrong id or secret
                    return response()->view('errors.500', [], 500);
                    break;

                case 'invalid_credentials':
                    // User: wrong username or password
                    return redirect()
                        ->route('login')
                        ->withInput($request->only(['email', 'remember']))
                        ->withErrors(['email' => 'Wrong email or password.']);
                    break;

                default:
                    return response()->view('errors.500', [], 500);
                    break;
            }
        }

        return parent::render($request, $exception);
    }
}
