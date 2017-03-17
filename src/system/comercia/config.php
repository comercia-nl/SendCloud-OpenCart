<?php
    namespace comercia;
    class Config{
        var $model;
        var $config;
        function __construct()
        {
            $this->model=Util::load()->model("setting/setting");
            $this->config=Util::registry()->get("config");
        }

        function get($key){
            return @$this->config->get($key)?:"";
        }

        function __get($name)
        {
           return $this->get($name);
        }

        function getGroup($code){
            return $this->model->getSetting($code);
        }

        function set($code,$key,$value=false){
            if(is_array($key)){
                $this->model->editSetting($code,$key);
            }else{
                $this->model->editSettingValue($code,$key,$value);
            }
        }
    }
?>