<?php
/**
 * Created by PhpStorm.
 * User: mtomczak
 * Date: 20/07/2017
 * Time: 10:22
 */

namespace Aranea;


class ConnectionException extends \Exception
{

    public function __construct()
    {
        parent::__construct(sprintf('Connection fatal error.'));
    }
}