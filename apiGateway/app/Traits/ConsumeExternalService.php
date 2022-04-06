<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Response;

trait ConsumeExternalService
{
    /**
     * Send request to any service
     * @param $method
     * @param $requestUrl
     * @param array $formParams
     * @param array $headers
     * @return string
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [])
    {
        $client = new Client([
            'base_uri'  =>  $this->baseUri,
        ]);
        if (isset($this->secret)) {
            $headers['Authorization'] = $this->secret;
        }

        $response = $client->request($method, 'api' . $requestUrl, [
            'form_params' => $formParams,
            'headers'     => $headers,
        ]);
        return $response->getBody()->getContents();
    }

    public function performMediaRequest($method, $requestUrl, $formParams = [], $headers = [])
    {
        $client = new Client([
            'base_uri'  =>  $this->baseUri,
        ]);

        if (isset($this->secret)) {
            $headers['Authorization'] = $this->secret;
        }

        $headers['Accept'] = 'application/json';


        $data = [];
        $data['headers'] = $headers;
        $data['query'] = $formParams;
        if (isset($formParams['picture'])) {
            $image = $formParams['picture'];
            $data['multipart'][] = array(
                'name' => 'picture',
                'contents' =>  file_get_contents($image),
                'filename' => 'image.jpg'
            );
        }
        // post request with attachment
        $response = $client->request($method, 'api' . $requestUrl, $data);
        return $response->getBody()->getContents();
    }
}
