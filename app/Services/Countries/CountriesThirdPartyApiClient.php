<?php

namespace app\Services\Countries;

use App\DataTransferObjects\CountryData;
use App\Http\Resources\CountryResource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Psr\Log\LoggerInterface;

class CountriesThirdPartyApiClient
{
    /**
     * @param Client $client
     * @param LoggerInterface $log
     * @param string $uri
     * @param array $options
     */
    public function __construct(
        private Client $client,
        private LoggerInterface $log,
        private string $uri,
        private array $options = [],
    )
    {
    }

    /**
     * @return AnonymousResourceCollection
     * @throws \Exception
     */
    public function listAllCountries(): AnonymousResourceCollection
    {
        try {
            $this->log->info(sprintf(
                'Fetching countries from %s with [%s] options.',
                $this->uri,
                json_encode($this->options))
            );
            $response = $this->client->get($this->uri, $this->options);
            $items = [];

            if ($response->getStatusCode() === 200) {
                $content = $response->getBody()->getContents();
                $content = json_decode($content, true);

                foreach ($content as $item) {
                    $items[] = CountryData::fromArray($item);
                }
            }
        } catch (GuzzleException $e) {
            $this->log->error($e->getMessage());
            throw new \Exception('Failed to fetch countries.');
        }

        return CountryResource::collection($items);
    }
}
