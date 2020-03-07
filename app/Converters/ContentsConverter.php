<?php

namespace App\Converters;

class ContentsConverter
{

    private $markdown, $markup, $markdownMap = [
        'editorjs' => 'EditorJSConverter'
    ];



    public function __construct(String $markdown, String $editor = 'editorjs')
    {
        $this->markdown = $markdown;

        $this->markup = call_user_func_array(
            array(__NAMESPACE__ . '\\' . $this->markdownMap[$editor],'getHtml'),
            array($this->markdown)
        );

    }



    public function getHtml()
    {
        return $this->markup;
    }
}
