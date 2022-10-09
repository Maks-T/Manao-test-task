<?php

namespace App\Exceptions;

use App\Controllers\HomeController;

class AppException
{
    private HomeController $homeController;

    const ROURE_NOT_FOUND = 1;
    const BAD_REQUEST = 400;
    const NOT_FOUND = 404;
    const INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->homeController = new HomeController();
        set_exception_handler(array($this, 'exception_handler'));
    }

    public function exception_handler($e)
    {
        switch ($e->getCode()) {
            case self::ROURE_NOT_FOUND:
                $this->homeController->index();
                break;
            case 400:
            case 401:
            case 404:
                http_response_code($e->getCode());
                echo $e->getMessage();
                break;
        }
    }
}
