<?php
namespace comercia;
class Route
{
    function extension()
    {
        return (Util::version()->isMinimal("2.3")) ? $path = 'extension/extension' : $path = 'extension/module';
    }
}

?>