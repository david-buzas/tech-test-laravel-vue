<?php

namespace App\DataTransferObjects;

readonly class CountryData
{
    /**
     * @param string $name
     * @param string $flagUrl
     */
    public function __construct(
        public string $name,
        public string $flagUrl
    )
    {
    }

    /**
     * @param array $data
     * @return CountryData
     */
    public static function fromArray(array $data): CountryData
    {
        $flag = $data['flags']['svg'] ??$data['flags']['png'];
        $name = $data['name']['official'];

        return new self($name, $flag);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'flag_url' => $this->flagUrl,
        ];
    }
}
