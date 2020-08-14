<?php

namespace App\Converters;

class ContentsConverter
{
    private $markup;
    private $markdownMap = [
        'editorjs' => 'EditorJSConverter',
        'editor' => 'EditorJSConverter',
    ];

    public function __construct($markdown, string $editor = 'editorjs')
    {
        // $this->markdown = $markdown;

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
