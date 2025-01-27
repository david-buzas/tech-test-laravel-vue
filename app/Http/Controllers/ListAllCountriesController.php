<?php

namespace App\Http\Controllers;

use app\Services\Countries\CountriesThirdPartyApiClient;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ListAllCountriesController extends Controller
{
    /**
     * @param CountriesThirdPartyApiClient $client
     */
    public function __construct(private CountriesThirdPartyApiClient $client)
    {
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        if (!Cache::has('countries_list')) {
            try {
                $resource = $this->client->listAllCountries();
                Cache::set('countries_list', $resource->toJson());
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                ], 404);
            }
        }

        return response(
            Cache::get('countries_list'),
            headers: ['Content-Type => application/json']
        );
    }
}

