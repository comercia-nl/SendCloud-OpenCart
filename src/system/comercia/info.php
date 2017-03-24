<?php
namespace comercia;
class Info
{
    function IsInAdmin(){
        global $application_context;
        return $application_context=="admin";
    }
}
?>