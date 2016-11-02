<?php
    namespace comercia;
    class Util{

        static function url(){
            static $url=false;
            if(!$url){
               require_once(__DIR__."/url.php");
                $url=new Url();
            }
            return $url;
        }

        static function version(){
            static $version=false;
            if(!$version) {
                require_once(__DIR__."/version.php");
                $version = new Version();
            }
            return $version;
        }
    }

?>