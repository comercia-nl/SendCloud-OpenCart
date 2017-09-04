<?php
namespace comercia;
class StringHelper
{
    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    function ccToUnderline($subject){
        return strtolower(preg_replace('/\B([A-Z])/', '_$1', lcfirst($subject)));
    }
}

?>
