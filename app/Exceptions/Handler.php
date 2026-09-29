<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException || $exception instanceof \PDOException) {
            report($exception);

            $message = 'Data tidak dapat diproses. Periksa isian Anda, atau hubungi admin jika masalah ini berulang.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 500);
            }

            return redirect()->back()->withInput()->with('error', $message);
        }

        return parent::render($request, $exception);
    }
}
