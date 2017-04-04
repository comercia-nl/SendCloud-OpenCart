<?php
namespace comercia;
class Url
{
    function link($route, $params = "", $ssl = true)
    {
        $session=Util::session();

        if ($session->token && $session->user_id && strpos($params,"route=")===false) {
            if($session->token){
                if($params){
                    $params.="&token=".$session->token;
                }else{
                    $params="token=".$session->token;
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