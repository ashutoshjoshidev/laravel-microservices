<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;

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
        try {

            $response = $client->request($method, 'api' . $requestUrl, [
                'form_params' => $formParams,
                'headers'     => $headers,
            ]);
            return $response->getBody()->getContents();
        } catch (Exception $e) {
            $response = [
                'errors' => 'Sorry, something went wrong.'
            ];

            // If the app is in debug mode
            if (config('app.debug')) {
                // Add the exception class name, message and stack trace to response
                $response['exception'] = get_class($e); // Reflection might be better here
                $response['message'] = $e->getMessage();
                $response['trace'] = $e->getTrace();
            }

            // Default response of 400
            $status = 400;

            // If this exception is an instance of HttpException
            $status = $e->statusCode;
            // Return a JSON response with the response array and status code
            return response()->json($response, $status);
        }
    }
}
