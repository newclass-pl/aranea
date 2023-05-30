<?php

namespace Aranea;

/**
 * Client
 * @package Aranea
 */
class Client
{

    /**
     * @var array
     */
    private $postExecute = [];

    /**
     * @var array
     */
    private $preExecute = [];

    /**
     * @var int
     */
    private $timeout = 90;

    /**
     * @param int $timeout max timeout in seconds
     * @return Client
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function addPostExecute($callback)
    {
        $this->postExecute[] = $callback;
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function addPreExecute($callback)
    {
        $this->preExecute[] = $callback;
    }



    /**
     * @param HTTPRequest $request
     * @return HTTPResponse|mixed
     * @throws ConnectionException
     */
    public function execute(HTTPRequest $request)
    {
        foreach ($this->preExecute as $execute) {
            call_user_func_array($execute, [$request]);
        }

        $curl = curl_init();
        try {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_URL, $request->getUrl());
            curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);

            if ($request->isAuth()) {
                curl_setopt($curl, CURLOPT_USERPWD, $request->getAuth());
            }

            $methods = [
                HTTPRequest::METHOD_POST,
                HTTPRequest::METHOD_PUT,
                HTTPRequest::METHOD_DELETE,
            ];

            if (in_array($request->getMethod(), $methods, true)) {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
                curl_setopt($curl, CURLOPT_POSTFIELDS, $request->getBody());
            }

            $headers = [];
            foreach ($request->getHeaders() as $header) {
                $headers[] = $header->__toString();
            }

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($curl);
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if (0 === $statusCode) {
                throw new ConnectionException();
            }

            $response = new HTTPResponse($statusCode, $result);

            foreach ($this->postExecute as $execute) {
                $response = call_user_func_array($execute, [$response]);
            }

            return $response;
        } finally {
            curl_close($curl);
        }
    }

    /**
     * @param string $url
     * @param array  $headers
     * @return HTTPResponse|mixed
     * @throws ConnectionException
     */
    public function requestGet($url, $headers = [])
    {
        $request = new HTTPRequest($url);

        foreach ($headers as $kHeader => $header) {
            $request->addHeader(new HTTPHeader($kHeader, $header));
        }

        return $this->execute($request);
    }

    /**
     * @param string $url
     * @param mixed  $attr
     * @param array  $headers
     * @return HTTPResponse
     * @throws ConnectionException
     */
    public function requestPost($url, $attr, $headers = [])
    {
        return $this->requestMethod(HTTPRequest::METHOD_POST, $url, $headers, $attr);
    }

    /**
     * @param string $url
     * @param mixed  $attr
     * @param array  $headers
     * @return HTTPResponse
     * @throws ConnectionException
     */
    public function requestPut($url, $attr, $headers = [])
    {
        return $this->requestMethod(HTTPRequest::METHOD_PUT, $url, $headers, $attr);
    }

    /**
     * @param string $url
     * @param mixed  $attr
     * @param array  $headers
     * @return HTTPResponse
     * @throws ConnectionException
     */
    public function requestDelete($url, $attr, $headers = [])
    {
        return $this->requestMethod(HTTPRequest::METHOD_DELETE, $url, $headers, $attr);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array  $headers
     * @param mixed  $attr
     * @return HTTPResponse
     * @throws ConnectionException
     */
    public function requestMethod($method, $url, array $headers, $attr)
    {
        $request = new HTTPRequest($url);

        foreach ($headers as $kHeader => $header) {
            $request->addHeader(new HTTPHeader($kHeader, $header));
        }

        $request->setMethod($method);
        $request->setBody($attr);

        return $this->execute($request);
    }

}