<?php

namespace App\Services;

class IpService
{
    public static function init()
    {
        $CLASS = config('services.ip_service');

        return new $CLASS($CLASS);
    }

}
