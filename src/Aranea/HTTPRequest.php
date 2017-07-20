<?php
/**
 * Aranea: Web client
 * Copyright (c) NewClass (http://newclass.pl)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the file LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) NewClass (http://newclass.pl)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Aranea;


class HTTPRequest
{
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const CONTENT_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_QUER_STRING = 'query_string';

    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $auth;

    /**
     * @var string
     */
    private $method;

    /**
     * @var mixed
     */
    private $body;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var HTTPHeader[]
     */
    private $headers=[];

    /**
     * HTTPRequest constructor.
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->setMethod(static::METHOD_GET);
        $this->setMethod(static::CONTENT_TYPE_QUER_STRING);
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getAuth()
    {
        return $this->auth;
    }

    public function isAuth()
    {
        return null!==$this->auth;
    }

    public function setAuth($login, $password)
    {
        $this->auth=$login.':'.$password;

        return $this;
    }

    /**
     * @param string $method
     * @return HTTPRequest
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $body
     * @return HTTPRequest
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        $transform=new RawTransform();
        if($this->getContentType()===static::CONTENT_TYPE_JSON){
            $transform=new JsonTranform();
        }
        return $transform->encode($this->body);
    }

    /**
     * @param string $contentType
     * @return HTTPRequest
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        //TODO search old content type and remove
        $this->addHeader(new HTTPHeader('Content-Type',$contentType));

        return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param HTTPHeader $header
     * @return HTTPRequest
     */
    public function addHeader($header)
    {
        $this->headers[]=$header;
        return $this;
    }

    /**
     * @return HTTPHeader[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

}