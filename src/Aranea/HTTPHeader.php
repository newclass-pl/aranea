<?php
/**
 * Created by PhpStorm.
 * User: mtomczak
 * Date: 30/06/2017
 * Time: 11:05
 */

namespace Aranea;


class HTTPHeader
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;

    /**
     * HTTPHeader constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name.': '.$this->value;
    }
}