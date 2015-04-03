<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:10 PM
 */

namespace YGL\Request;

use ODataQuery\ODataResourceInterface;
use ODataQuery\ODataResourcePath;
use YGL\Response\YGLResponse;
use YGL\YGLClient;

abstract class YGLRequest extends ODataResourcePath
{
    private $url = 'https://www.youvegotleads.com/api/';
    protected $client;
    protected $headers = array();
    protected $function;
    protected $data;

    public function __construct(
        $clientToken = null,
        ODataResourceInterface $query = null
    ) {
        if (isset($accessToken) && is_string($clientToken)) {
            // $clientToken is accessToken
            $this->client = new YGLClient($clientToken);
        } elseif (isset($clientToken) && $clientToken instanceof YGLClient) {
            $this->setClient($clientToken);
        }

        if (isset($query)) {
            $this->setQuery($query);
        }

        $this->headers['Host'] = isset($_SERVER['HTTP_HOST'])
            ? $_SERVER['HTTP_HOST'] : 'localhost';
        $this->headers['Accept'] = 'application/json';
        $this->headers['Content-Type'] = 'application/json';
    }

    public function setQuery(ODataResourceInterface $query)
    {
        $this->select($query->select());
        $this->search($query->search());
        $this->pager($query->pager());
        $this->filter($query->filter());
        $this->expand($query->expand());
        $this->orderBy($query->orderBy());
        return $this;
    }

    public function setAccessToken($accessToken)
    {
        $client = $this->getClient();
        if (isset($client)) {
            $client->setAccessToken($accessToken);
        }

        return $this;
    }

    public function setClient(YGLClient $client)
    {
        $this->client = $client;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setBody($data)
    {
        $this->data = json_encode($data);

        return $this;
    }

    public function setFunction($function)
    {
        $this->function = $function;
        $this->path($this->url . $this->function);

        return $this;
    }

    abstract public function refreshFunction();

    public function build()
    {
        $params = array();

        if (empty($this->data)) {
            $params = parent::build();
        }
        return $params;
    }

    public function send()
    {
        $path = (string)$this;
        $method = !empty($this->data) ? HttpRequest::METHOD_JSON
            : HttpRequest::METHOD_GET;

        $request = new HttpRequest(
            $path,
            $method,
            $this->data,
            $this->headers
        );

        if (strlen($this->client->getUsername()) > 0) {
            $request->setHttpAuth(
                HttpRequest::AUTH_BASIC,
                $this->client->getUsername(),
                $this->client->getPassword()
            );
        }

        $response = $request->send();

        return new YGLResponse($response);
    }

    public function __set($name, $value)
    {
        if ($name == 'accessToken' && isset($this->client)) {
            $this->getClient()->setAccessToken($value);
        }
    }
} 