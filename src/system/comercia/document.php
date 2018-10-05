<?php

namespace comercia;
class Document
{
    var $document;
    var $variables = array();

    function __construct()
    {
        $this->document = Util::registry()->get("document");
    }

    public function setTitle($title)
    {
        $this->document->setTitle($title);
        return $this;
    }

    public function setDescription($description)
    {
        $this->document->setDescription($description);
        return $this;
    }

    public function setKeywords($keywords)
    {
        $this->document->setKeywords($keywords);
        return $this;
    }

    public function addLink($href, $rel)
    {
        $this->document->addLink(Util::http()->getPathFor($href), $rel);
        return $this;
    }

    public function addStyle($href, $rel = 'stylesheet', $media = 'screen')
    {
        global $journal2;
        if (@$journal2) {
            $journal2->minifier->addStyle(Util::http()->getPathFor($href));
        } else {
            $this->document->addStyle(Util::http()->getPathFor($href), $rel, $media);
        }
        return $this;
    }

    public function addScript($href, $position = 'header')
    {
        global $journal2;
        if (@$journal2) {
            $journal2->minifier->addScript(Util::http()->getPathFor($href));
        } else {
            $this->document->addScript(Util::http()->getPathFor($href), $position);
        }
        return $this;
    }

    public function addVariable($name, $value)
    {
        $this->variables[$name] = $value;
        return $this;
    }


    function addDependency($file, $inTheme = false)
    {

        if (is_array($file)) {
            $files = $file;
            foreach ($files as $file) {
                $this->addDependency($file, $inTheme);
            }
            return $this;
        }

        if ($inTheme) {
            $file = Util::info()->theme(true) . $file;
        }

        $exp = explode(".", $file);
        $ext = $exp[count($exp) - 1];
        if ($ext == "css") {
            $this->addStyle($file);
        }
        if ($ext == "js") {
            $this->addScript($file);
        }
        return $this;
    }
}


?>