<?php

namespace App\Services;

interface IpServiceInterface
{
    public function getCountry(?string $ip_address): string;
}
