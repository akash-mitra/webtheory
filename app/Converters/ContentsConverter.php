<?php

namespace App\Converters;

class ContentsConverter
{
    private $markup;
    private $markdownMap = [
        'editorjs' => 'EditorJSConverter',
        'editor' => 'EditorJSConverter',
        'html' => 'EditorHTMLConverter',
    ];

    public function __construct($markdown, string $editor = 'editorjs')
    {
        // calculate the markup for a given markdown b
        // by invoking related converter.

        $this->markup = call_user_func_array(
            [__NAMESPACE__ . '\\' . $this->markdownMap[$editor], 'getHtml'],
            [$markdown]
        );
    }

    public function getHtml()
    {
        return $this->markup;
    }
}
