<?php
namespace comercia;
class Document
{
    var $document;
    var $variables=array();

    function __construct()
    {
        $this->document=Util::registry()->get("document");
    }

    public function setTitle($title)
    {
        $this->document->setTitle($title);
    }

    public function setDescription($description)
    {
        $this->document->setDescription($description);
    }

    public function setKeywords($keywords)
    {
        $this->document->setKeywords($keywords);
    }

    public function addLink($href, $rel)
    {
        $this->document->addLink(Util::http()->getPathFor($href),$rel);
    }

    public function addStyle($href, $rel = 'stylesheet', $media = 'screen')
    {
        $this->document->addStyle(Util::http()->getPathFor($href),$rel,$media);
    }

    public function addScript($href, $postion = 'header')
    {
        $this->document->addScript(Util::http()->getPathFor($href),$postion);
    }

    public function addVariable($name,$value)
    {
        $this->variables[$name]=$value;
    }
}


?>