<?php


namespace App\Http\Service\response;


use stdClass;

class JsonResponse
{
    /**
     * Hide default constructor to enforce setting of version
     * @param $user
     * @param null $status
     */
    public function __construct($user = null, $status = null) {
        $this->version = config('kbdb.jsonApiVersion');
        if ($user != null) {
            $this->user = new ResponseUser($user);
        }
        if ($status) {
            $this->status = $status;
        } else {
            $this->status = new ResponseStatus();
        }
    }

    /**
     *
     * @var string
     */
    public $version;

    /**
     * The authenticated user handle
     * @var
     */
    public $user;

    /**
     * @var ResponseStatus
     */
    public $status;

    /**
     * The data when successful
     * @var stdClass
     */
    public $result;

}
