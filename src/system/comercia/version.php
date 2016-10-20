<?php
namespace comercia;
class Version
{
    private $version;
    function __construct()
    {
        $this->version=explode(".",VERSION);
    }

    function get(){
        return $this->version;
    }
    function isMinimal($s0=0,$s1=0,$s2=0,$s3=0){
        return $this->version[0]>=$s0 && $this->version[1]>=$s1 && $this->version[2]>=$s2 &&$this->version[3]>=$s3;
    }
}