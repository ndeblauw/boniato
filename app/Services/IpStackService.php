<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IpStackService implements IpServiceInterface
{
    public string $endpoint;

    public string $key;

    public function __construct()
    {
        $this->endpoint = config('services.ipstack.endpoint');
        $this->key = config('services.ipstack.key');
    }

    public function getCountry(?string $ip_address): string
    {
        if ($ip_address === null) {
            return 'Belgium';
        }

        $data = $this->getIpInfo($ip_address);

        return $data['country_name'] ?? 'unknown';
    }

    public function getIpInfo(string $ip_address)
    {
        try {
            $response = Http::get($this->endpoint.$ip_address, [
                'access_key' => $this->key,
            ]);

            return $response->json();

        } catch (\Exception $e) {
            return $response = ['country_name' => 'unknow'];
        }

    }
}
