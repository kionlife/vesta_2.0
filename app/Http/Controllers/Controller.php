<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * return error response.
     *
     * @return array
     */
    public function sendResponseMessage($message, $code = 200)
    {
        switch ($code) {
            case 200:
                $status = 'Операція успішна';
                $class = 'success';
                break;
            default:
                $status = 'Невідома помилка';
                $class = 'danger';
        }


        $response = [
            'status'  => $status,
            'class'   => $class,
            'message' => $message,
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
}
