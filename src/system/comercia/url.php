<?php
namespace comercia;
class Url
{
    function image($image){
        if(Util::info()->IsInAdmin()) {
            if (defined(HTTPS_CATALOG)) {
                return HTTPS_CATALOG . "image/" . $image;
            }
            return HTTP_CATALOG . "image/" . $image;
        }
        if (defined(HTTPS_SERVER)) {
            return HTTPS_SERVER . "image/" . $image;
        }
        return HTTP_SERVER . "image/" . $image;
    }

    function catalog($route, $params = "", $ssl = true){
        $url=$this->getCatalogUrl($ssl)."index.php?route=".$route;
        if($params){
            $url.="&".$params;
        }
        return $url;
    }

    function getCatalogUrl($ssl=true){
        if(Util::info()->IsInAdmin()) {
            if (defined(HTTPS_CATALOG) && $ssl) {
                return HTTPS_CATALOG;
            }
            return HTTP_CATALOG;
        }
        if (defined(HTTPS_SERVER) && $ssl) {
            return HTTPS_SERVER;
        }
        return HTTP_SERVER;
    }

    function link($route, $params = "", $ssl = true)
    {
        $session = Util::session();

        if ($session->token && $session->user_id && strpos($params,"route=")===false) {
            if ($session->token) {
                if ($params) {
                    $params .= "&token=" . $session->token;
                } else {
                    $params = "token=" . $session->token;
                }
            }
        }

        if ($ssl && !defined(HTTPS_SERVER)) {
            $ssl = false;
        }

        if (!$ssl) {
            return $this->_url()->link($route, $params);
        } else {
            if (Util::version()->isMinimal("2.2")) {
                return $this->_url()->link($route, $params, true);
            } else {
                return $this->_url()->link($route, $params, "ssl");
            }
        }
    }

    private function _url()
    {
        $registry = Util::registry();
        if (!$registry->has('url')) {
            $registry->set('url', new Url(HTTP_SERVER));
        }

        return $registry->get("url");
    }
}

?>