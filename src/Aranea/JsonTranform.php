<?php
/**
 * Created by PhpStorm.
 * User: mtomczak
 * Date: 30/06/2017
 * Time: 10:57
 */

namespace Aranea;


class JsonTranform implements TransformInterface
{

    /**
     * @param mixed $values
     * @return false|string
     * @throws InvalidTypeException
     */
    public function encode($values)
    {
        if (!is_array($values)) {
            throw new InvalidTypeException();
        }

        return json_encode($values);
    }

    /**
     * @param mixed $data
     * @return mixed
     * @throws InvalidTypeException
     */
    public function decode($data)
    {
        if (!is_string($data)) {
            throw new InvalidTypeException();
        }

        return json_decode($data, true);
    }
}