<?php
namespace comercia;
class Info
{
    function IsInAdmin(){
        global $application_context;
    if (Util::version()->isMinimal("2.3")) {
        return $application_context=="admin";
    } else if (defined('DIR_CATALOG')) {
        return $application_context = "admin";
    }
}
}
?>