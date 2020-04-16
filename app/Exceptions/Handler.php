<?php

namespace App\Exceptions;

use App\Http\Service\ServiceException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        NotFoundHttpException::class,
        // Don't report MyCustomException, it's only for returning son errors.
        ServiceException::class
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
     * @param Exception $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request  $request
     * @param Exception $exception
     * @return Response
     *
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        Log::error('Request:');
        Log::error($request);
        Log::error('Exception message:');
        Log::error($exception->getMessage());
        if ($request->ajax() || $request->wantsJson()) {
            if (Auth::check()) {
                return response()->json(
                    ['version' => config('kbdb.jsonApiVersion'),
                        'user' => Auth::user(),
                        'status' => (object)['message' => $exception->getMessage(),
                            'code' => 500,
                        ]
                    ]
                );
            } else {
                Log::info('Authentication failed for user:');
                Log::info(Auth::user());
                return response()->json(
                    [ 'version' => config('kbdb.jsonApiVersion'),
                        'user' => null,
                        'status' => (object)['message' => 'Not authenticated',
                        'code' => 401,
                            ]
                    ]
                );
            }
        }
        return parent::render($request, $exception);
    }
}
