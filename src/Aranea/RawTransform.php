<?php
/**
 * Created by PhpStorm.
 * User: mtomczak
 * Date: 30/06/2017
 * Time: 10:55
 */

namespace Aranea;

/**
 * RawTransform
 * @package Aranea
 */
class RawTransform implements TransformInterface
{

    /**
     * @param mixed $values
     * @return array
     */
    public function encode($values)
    {
        $result = [];
        foreach ($values as $key => $value) {
            $dataDeeps = $this->encodeDeep($key, $value);
            foreach ($dataDeeps as $dataDeep) {
                $result[$dataDeep[0]] = $dataDeep[1];
            }
        }

        return $result;
    }

    /**
     * @param string $key
     * @param array $values
     * @return array
     */
    private function encodeDeep($key, $values)
    {
        $result = [];
        if (is_array($values)) {

            foreach ($values as $i => $value) {
                $data = $this->encodeDeep($key.'['.$i.']', $value);
                $result = array_merge($result, $data);
            }

            return $result;

        }

        return [
            [
                $key,
                $values,
            ],
        ];
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function decode($data)
    {
        return $data;
    }
}