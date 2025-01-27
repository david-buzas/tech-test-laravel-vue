<?php

namespace App\Http\Controllers;

use app\Services\Countries\CountriesThirdPartyApiClient;
use Illuminate\Support\Facades\Cache;

class ListAllCountriesController extends Controller
{
    /**
     * @param CountriesThirdPartyApiClient $client
     */
    public function __construct(private CountriesThirdPartyApiClient $client)
    {
    }

    /**
     * @return string
     */
    public function index(): string
    {
        return Cache::remember('countries_list', '86400', function () {
            $resource = $this->client->listAllCountries();

            return $resource->toJson();
        });
    }
}

