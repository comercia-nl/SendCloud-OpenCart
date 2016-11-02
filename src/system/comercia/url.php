<?php
    namespace comercia;
    class Url{
        function link($route,$params="",$ssl=false){
            if(!$ssl){
                return $this->_url()->link($route,$params);
            }else{
                if(Util::version()->isMinimal(2,2)){
                    return $this->_url()->link($route,$params,true);
                }else{
                    return $this->_url()->link($route,$params,"ssl");
                }
            }
        }

        private function _url(){
            global $registry;
            return $registry->get("url");
        }
    }
?>