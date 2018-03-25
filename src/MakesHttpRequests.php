<?php

namespace Bdok\PostGateway;

use Psr\Http\Message\ResponseInterface;
use Bdok\PostGateway\Exceptions\TimeoutException;
use Bdok\PostGateway\Exceptions\NotFoundException;
use Bdok\PostGateway\Exceptions\ValidationException;
use Bdok\PostGateway\Exceptions\FailedActionException;
use Bdok\PostGateway\Exceptions\InvalidApiKeyException;

trait MakesHttpRequests
{
    /**
     * Make a POST request to server and return the response.
     *
     * @param string $uri
     * @param array  $payload
     *
     * @return mixed
     */
    private function post($uri, array $payload = [])
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * Make request to server and return the response.
     *
     * @param string $verb
     * @param string $uri
     * @param array  $payload
     *
     * @return mixed
     */
    private function request($verb, $uri, array $payload = [])
    {
        $response = $this->guzzle->request($verb, $uri,
            empty($payload) ? [] : ['form_params' => $payload]
        );

        if ($response->getStatusCode() != 200) {
            return $this->handleRequestError($response);
        }

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \Exception
     * @throws ValidationException
     * @throws InvalidApiKeyException
     * @throws NotFoundException
     * @throws FailedActionException
     *
     * @return void
     */
    private function handleRequestError(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 422) {
            throw new ValidationException(json_decode((string) $response->getBody(), true));
        }

        if ($response->getStatusCode() == 401) {
            throw new InvalidApiKeyException('کد API صحیح نیست.');
        }

        if ($response->getStatusCode() == 404) {
            throw new NotFoundException();
        }

        if ($response->getStatusCode() == 400 || $response->getStatusCode() == 500) {
            throw new FailedActionException((string) $response->getBody());
        }

        throw new \Exception((string) $response->getBody());
    }

    /**
     * Retry the callback or fail after x seconds.
     *
     * @param int      $timeout
     * @param callable $callback
     *
     * @throws TimeoutException
     *
     * @return mixed
     */
    public function retry($timeout, $callback)
    {
        $start = time();

        beginning:

        if ($output = $callback()) {
            return $output;
        }

        if (time() - $start < $timeout) {
            sleep(5);

            goto beginning;
        }

        throw new TimeoutException($output);
    }
}
