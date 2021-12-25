<?php

namespace App\Service;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

/**
 * Class apiHelper
 * @codeCoverageIgnore
 * @package App\Helper
 */
class ApiHelper
{
    /**
     * @var string
     */
    private $apiUrl;
    /**
     * @var Client
     */
    private $client;
    /**
     * @var array
     */
    private $header;
    /**
     * apiHelper constructor.
     *
     * @param string|null $fullUrl
     */
    const PAGE = 'page=';

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->client = new Client($this->getClientOptions());
        $this->header = [
            'verify' => false,
            'http_errors' => false
        ];
    }

    /**
     * @param $payload
     * @return mixed
     */
    public function getResponseContentFromPayload($payload)
    {
        $response = $this->sendHttpPostRequest($payload);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param $payload
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @codeCoverageIgnore
     */
    public function sendHttpPostRequest($payload): \Psr\Http\Message\ResponseInterface
    {
        $this->addParam(['form_params' => $payload]);
        return $this->client->post($this->apiUrl, $this->getHeader());
    }

    /**
     * @param $objectId
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @codeCoverageIgnore
     */
    public function sendHttpDeleteRequest($objectId): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->delete($this->apiUrl . '/' . $objectId, $this->getHeader());
    }

    /**
     * @param null $objectId
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @codeCoverageIgnore
     */
    public function sendHttpGetRequest($objectId = null): \Psr\Http\Message\ResponseInterface
    {
        $url = $this->apiUrl;
        if ($objectId !== null) {
            $url = $this->apiUrl . '/' . $objectId;
        }
        $this->logger->debug(sprintf('Doing GET request to url: %s, with param %s', $url, json_encode($this->getHeader())));
        return $this->client->get($url, $this->getHeader());
    }

    /**
     * @param string $url
     *
     * @return array
     */
    public function getAllObjectFromUrl(string $url)
    {
        $this->addHeader(['accept' => 'application/ld+json']);
        $ret = [];
        $page = 1;
        $addParam = '?';
        if (strpos($url, '?') !== false) {
            $addParam = '&';
        }
        do {
            $this->setApiUrl($url . $addParam . self::PAGE . $page);
            $response = $this->sendHttpGetRequest();
            $decodedResponse = json_decode($response->getBody()->getContents(), true);
            $ret[] = $decodedResponse['hydra:member'];
            $page++;
        } while (isset($decodedResponse['hydra:view']['hydra:next']));
        $ret = array_merge(...$ret);
        return $ret;
    }


    /**
     * @param null $objectId
     * @return mixed
     */
    public function sendHttpGetContentRequest($objectId = null)
    {
        $request = $this->sendHttpGetRequest($objectId);
        return json_decode($request->getBody()->getContents(), true);
    }


    /**
     * @return array
     */
    public function getClientOptions(): array
    {
        return ['http_errors' => false,];
    }

    /**
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param mixed $apiUrl
     *
     * @return ApiHelper
     * @codeCoverageIgnore
     */
    public function setApiUrl($apiUrl): ApiHelper
    {
        $this->apiUrl = $apiUrl;
        return $this;
    }

    /**
     * @return Client
     * @codeCoverageIgnore
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return ApiHelper
     * @codeCoverageIgnore
     */
    public function setClient(Client $client): ApiHelper
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @param array $array
     */
    public function addHeader(array $array)
    {
        foreach ($array as $key => $value) {
            $this->header['headers'][$key] = $value;
        }
    }

    public function addParam(array $array)
    {
        foreach ($array as $key => $value) {
            $this->header[$key] = $value;
        }
    }

    /**
     * @param $name
     */
    public function removeHeader($name)
    {
        unset($this->header['headers'][$name]);
    }

    /**
     * @param null $payload *
     * @return array
     */
    public function getHeader($payload = null): array
    {
        if ($payload !== null) {
            $this->header['form_params'] = $payload;
        }
        return $this->header;
    }

    public function resetOption(){
        $this->header = [
            'verify' => false,
            'http_errors' => false
        ];
        $this->apiUrl = null;
    }
}
