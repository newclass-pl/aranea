<?php

namespace Aranea;

/**
 * ConnectionException
 * @package Aranea
 */
class ConnectionException extends \Exception
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct('Connection fatal error.');
    }
}