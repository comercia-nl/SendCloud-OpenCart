<?php
    namespace comercia;
    class Util{

        static function url(){
            static $url=false;
            if(!$url){
               require_once(__DIR__."url.php");
                $url=new Url();
            }
            return $url;
        }

        static function version(){
            static $version=false;
            if(!$version) {
                $version = new Version();
            }
            return $version;
        }
    }

?>