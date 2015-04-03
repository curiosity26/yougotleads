<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 11:31 PM
 */

namespace YGL\Response;


class YGLResponse
{
    protected $code;
    protected $headers;
    protected $response;
    protected $body;

    public function __construct(HttpResponse $response = null)
    {
        if (isset($response)) {
            $this->setResponse($response);
        }
    }

    public function setResponse(HttpResponse $response)
    {
        $this->response = $response;
        $this->setResponseCode($response->getResponseCode());
        $this->setHeaders($response->getHeaders());
        $this->setBody($response->getResonseBody());

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponseCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getResponseCode()
    {
        return $this->code;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function isSuccess()
    {
        return in_array(
            $this->getResponseCode(),
            array(200, 201, 202, 206, 302, 304)
        ); // 201 is reserved for successful posts
    }

} 