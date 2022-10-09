<?php

namespace App\Exceptions;

use App\Controllers\HomeController;

class AppException
{
    private HomeController $homeController;

    const ROURE_NOT_FOUND = 1;

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
            case 2:
                echo "i равно 2";
                break;
        }
    }
}
