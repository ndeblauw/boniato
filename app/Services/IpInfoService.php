<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IpInfoService
{
    public string $endpoint;
    public string $token;
    public function __construct()
    {
        $this->endpoint = config('services.ipinfo.endpoint');
        $this->token = config('services.ipinfo.token');
    }

    public function getCountry(string $ip_address): string
    {
        $data = $this->getIpInfo($ip_address);

        return $data['country'];
    }

    public function getIpInfo(string $ip_address)
    {
        try {
            $response = Http::get($this->endpoint.$ip_address, [
                'token' => $this->token
            ]);

            return $response->json();

        } catch(\Exception $e) {
            return $response = ['country' => 'unknow'];
        }

    }

}
