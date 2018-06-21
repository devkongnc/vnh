<?php

namespace App\Exceptions;

use App\Estate;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $sitemap = config('sitemap');
        $key = trim($request->getRequestUri(), '/');
        if (isset($sitemap[$key])) {
            return redirect()->to($sitemap[$key], 301);
        }
        $key = str_replace("vn/", "", $key);
        $key = str_replace("jp/", "", $key);
        $key = str_replace("en/", "", $key);
        $key = preg_replace("/-(en|vn|jp)(-.)?.html/", "", $key);
        $key = str_replace(".html", "", $key);
        $estate = Estate::query()->where('slug_vi', 'LIKE', "%{$key}%")->orWhere('slug_en', 'LIKE', "%{$key}%")->first();
        if ($estate != null) {
            return redirect()->action('RealEstateController@show', $estate->product_id);
        }
        /*if ($e instanceof AuthorizationException or $e instanceof HttpException or $e instanceof NotFoundHttpException)
            return response()->view('errors.404', [], 404);
        elseif (!env('APP_DEBUG') && !($e instanceof ValidationException) ) return response()->view('errors.500', [], 500);*/
        return parent::render($request, $e);
    }
}
