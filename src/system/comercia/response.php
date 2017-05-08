<?php
namespace comercia;
class Response
{
    function redirect($route, $params = "", $ssl = true)
    {
        $url = Util::url()->link($route, $params, $ssl);
       $this->redirectToUrl($url);
    }

    function redirectToUrl($url){
        Util::registry()->get("response")->redirect($url);
    }

    function addHeader($key, $value)
    {
        Util::registry()->get("response")->addHeader($key . ":" . $value);
    }

    function setCompression($level)
    {
        Util::registry()->get("response")->setCompression($level);
    }

    function view($view, $data = array(), $pageControllers = true)
    {
        if ($pageControllers) {
            Util::load()->pageControllers($data);
        }
        $result = Util::load()->view($view, $data);
        $this->write($result);
    }

    function write($output)
    {
        Util::registry()->get("response")->setOutput($output);
    }
}

?>