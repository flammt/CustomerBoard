<?php


namespace App\Http\Service\response;


class ResponseUser
{
    public $email;

    public function __construct($user) {
        $this->email = $user->email;
    }
}
