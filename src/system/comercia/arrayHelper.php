<?php
namespace comercia;
class ArrayHelper
{

    function keepPrefix($prefix, $array)
    {
        foreach ($array as $key => $value) {
            if (!Util::stringHelper()->startsWith($key, $prefix)) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    function keyToVal($data)
    {
        $new = array();
        foreach ($data as $key => $val) {
            $new[$key] = $key;
        }
        return $new;
    }

}

?>