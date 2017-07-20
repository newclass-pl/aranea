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


class HTTPResponse
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var string
     */
    private $body;
    /**
     * @var HTTPHeader[]
     */
    private $headers=[];

    /**
     * HTTPResponse constructor.
     * @param int $statusCode
     * @param string $data
     */
    public function __construct($statusCode,$data)
    {
        $this->statusCode = $statusCode;
        $this->parseContent($data);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    private function parseContent($data)
    {
        list($headers, $body) = explode("\r\n\r\n", $data, 2);
        $lines=explode("\r\n",$headers);
        //TODO detect version
        for($i=1; $i< count($lines); $i++){
            $line=$lines[$i];
            $field=explode(': ',$line,2);
            $this->headers[]=new HTTPHeader($field[0],$field[1]);
        }
        //TODO detect content type
        $this->body=$body;
    }

    /**
     * @return HTTPHeader[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

}