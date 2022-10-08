<?php

declare(strict_types=1);

namespace App;

use Phpenv\Env;

class ConfigApp
{
    public function __construct()
    {
        $envFile = realpath("./../.env");
        Env::load($envFile);
    }

}