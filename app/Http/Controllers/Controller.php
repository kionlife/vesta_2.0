<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Traits\PaginationTrait;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, PaginationTrait;

    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();

            return $next($request);
        });
    }

    /**
     * return error response.
     *
     * @return array
     */
    public function sendResponseMessage($message = '', $code = 200, $success = false)
    {
        switch ($code) {
            case 200:
                $status = 'Операція успішна';
                $class = 'success';
                $success = true;
                break;
            default:
                $status = 'Невідома помилка';
                $class = 'danger';
        }


        $response = [
            'status'  => $status,
            'class'   => $class,
            'message' => $message,
            'success' => $success
        ];

        return $response;
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response(view('errors/404', [
            'response' => $response,
            'code' => $code
        ]), $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function sendErrorMessage($error, $errorMessages = [], $code = 422)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response($response, $code);
    }
}
