<?php
/**
 * Created by PhpStorm.
 * User: mtomczak
 * Date: 11/08/2017
 * Time: 08:20
 */

namespace Aranea;


class InvalidTypeException extends \Exception
{

    /**
     * InvalidTypeException constructor.
     */
    public function __construct()
    {
        parent::__construct('Invalid type.');
    }
}