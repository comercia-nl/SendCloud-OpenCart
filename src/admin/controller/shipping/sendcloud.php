<?php
class ControllerShippingSendcloud extends Controller
{
    function index(){
        \comercia\Util::response()->redirect(\comercia\Util::route()->extension("sendcloud"));
    }
}