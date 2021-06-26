<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Exception;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($request->is('api/*')) {
             return $this->handleException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    public function handleException($request, Exception $exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $response['message'] = 'Method Not Allowed';
            $response['status'] = false;
            $response['status_code'] = $statusCode;
            return response()->json($response, $statusCode);
        }

        if ($exception instanceof NotFoundHttpException) {
            $response['message'] = 'Not Found';
            $response['status'] = false;
            $response['status_code'] = $statusCode;
            return response()->json($response, $statusCode);
        }

        if ($exception instanceof HttpException) {
            $response['message'] = $exception->getMessage();
            $response['status'] = false;
            $response['status_code'] = $statusCode;
            return response()->json($response, $statusCode);
        }
        if ($exception instanceof AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
            $response['message'] = 'Authentication Error';
            $response['status'] = false;
            $response['status_code'] = $exception->getStatusCode();
            return response()->json($response, $statusCode);
        }
        if ($exception instanceof ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
            $response['message'] = 'Validation Error';
            $response['status'] = false;
            $response['status_code'] = $exception->getStatusCode();
            return response()->json($response, $statusCode);
        }
        if ($exception instanceof AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
            $response['message'] = 'Authentication Error';
            $response['status'] = false;
            $response['status_code'] = $exception->getStatusCode();
            return response()->json($response, $statusCode);
        }
        if ($exception instanceof ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
            $response['message'] = 'Validation Error';
            $response['status'] = false;
            $response['status_code'] = $exception->getStatusCode();
            return response()->json($response, $statusCode);
        }
        if (config('app.debug')) {
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
            $response['status'] = false;
            $response['status_code'] = $statusCode;
            return response()->json($response, $statusCode);
        }
        $response['message'] = $exception->getMessage();
        $response['status'] = false;
        $response['status_code'] = $statusCode;
        return response()->json($response, $statusCode);

    }

}
