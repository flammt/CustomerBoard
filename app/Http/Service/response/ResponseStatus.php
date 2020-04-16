<?php


namespace App\Http\Service\response;


class ResponseStatus
{
    public $code;
    public $message;

    public function __construct($code = 200, $message = '') {
        $this->code = $code;
        $this->message = $message;
    }
}
