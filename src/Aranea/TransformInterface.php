<?php
/**
 * Created by PhpStorm.
 * User: mtomczak
 * Date: 30/06/2017
 * Time: 10:55
 */

namespace Aranea;


interface TransformInterface
{
    /**
     * @param $values
     * @return mixed
     */
    public function encode($values);

    /**
     * @param mixed $data
     * @return mixed
     */
    public function decode($data);
}