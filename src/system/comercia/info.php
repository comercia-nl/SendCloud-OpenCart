<?php
namespace comercia;
class Info
{
    function IsInAdmin()
    {
        global $application_context;
        return $application_context !== null && $application_context == "admin" ||
            (defined("HTTPS_CATALOG") && HTTPS_CATALOG != HTTPS_SERVER || defined("HTTP_CATALOG") && HTTP_CATALOG != HTTPS_SERVER);
    }

    function theme()
    {
        return Util::config()->config_template;
    }
}

?>