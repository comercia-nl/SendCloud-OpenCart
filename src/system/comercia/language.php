<?php
namespace comercia;
class Language
{
    private $language;

    function __construct()
    {
        $this->language = Util::registry()->get("language");
    }

    function __get($name)
    {
        return $this->get($name);
    }

    function get($name)
    {
        return @$this->language->get($name) ?: "";
    }


}

?>