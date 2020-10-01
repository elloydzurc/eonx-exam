<?php

namespace App\Domain;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class CustomersImporter
 *
 * @package App\Services
 */
class CustomersImporter
{
    /**
     * Import customers from provider
     *
     * @return mixed
     */
    public function import()
    {
        try {
            $config = config('importer');
            $provider = ($config['providers'])[$config['default']];

            if (!filter_var($provider['api_url'], FILTER_VALIDATE_URL)) {
                throw new Exception('Invalid API URL');
            }

            $response = Http::get($provider['api_url'], $provider['params']);
            if (!$response->successful()) {
                return null;
            }

            return $this->mapApiData(
                $response->body(),
                $provider['root_element']
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return null;
    }

    /**
     * @param $data
     * @param string $rootElement
     * @return mixed
     */
    private function mapApiData($data, string $rootElement)
    {
        try {
            if ($this->isJson($data)) {
                $format = 'json';
                $data = (json_decode($data, true))[$rootElement];
            } else {
                $format = 'xml';
                $data = (simplexml_load_string($data))->{$rootElement};
            }

            if (!$data) {
                throw new Exception('No data found with root element of ' . $rootElement);
            }

            $mapper = MapperFactory::create('customer', $format);
            return $mapper->mapData($data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return null;
    }

    /**
     * @param $string
     * @return bool
     */
    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
