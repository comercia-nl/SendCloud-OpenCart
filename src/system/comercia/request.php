<?php
namespace comercia;
class Request
{
    function get()
    {
        static $get = false;
        if (!$get) {
            $get = new ArrayObject(Util::registry("load")->get("request")->get);
        }
        return $get;
    }

    function post()
    {
        static $post = false;
        if (!$post) {
            $post = new ArrayObject(Util::registry("load")->get("request")->post);
        }
        return $post;
    }

    function server()
    {
        static $server = false;
        if (!$server) {
            $server = new ArrayObject(Util::registry("load")->get("request")->server);
        }
        return $server;
    }
}

?>