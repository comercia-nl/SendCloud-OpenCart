<?php
namespace comercia;
class ArrayObject
{
    private $data;

    function __construct(&$data)
    {
        $this->data =& $data;
    }

    function __get($name)
    {
        return @$this->data[$name] ?: "";
    }

    function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    function remove($name)
    {
        unset($this->data[$name]);
    }

    function all()
    {
        return $this->data;
    }
}

?>