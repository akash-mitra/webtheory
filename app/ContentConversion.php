<?php

namespace App;

use Highlight\Highlighter;

class ContentConversion
{
    private static $body_json;
    private static $langSearchSpace = ['java', 'python', 'javascript', 'php', 'sql'];

    public static function getHtml(String $body_json)
    {
        self::$body_json = json_decode($body_json);

        $body_html = '';
        foreach (self::$body_json->blocks as $block) {
            $body_html .= self::processContent($block->type, $block->data);
        }

        return $body_html;
    }

    private static function processHeader($data)
    {
        return '<h' . $data->level . '>' . $data->text . '</h' . $data->level . '>';
    }

    private static function processParagraph($data)
    {
        return '<p>' . $data->text . '</p>';
    }

    private static function processList($data)
    {
        $list = $data->style == 'ordered' ? '<ol>' : '<ul>';
        $items = $data->items;
        foreach ($items as $item) {
            $list .= '<li>' . $item . '</li>';
        }
        $list .= $data->style == 'ordered' ? '</ol>' : '</ul>';
        return $list;
    }

    private static function processTable($data)
    {
        $table = '<table class="w-full table-auto my-4"><tbody>';
        $content = $data->content;
        foreach ($content as $rows) {
            $table .= '<tr class="border-b">';
            foreach ($rows as $row) {
                $value = strip_tags($row);
                $table .= '<td class="py-2">' . $value . '</td>';
            }
            $table .= '<tr>';
        }
        $table .= '</tbody></table>';
        return $table;
    }

    private static function processCode($data)
    {
        return self::getCodeHighLighted($data->code);

    }

    private static function processImage($data)
    {
        $classes = $data->withBorder ? ' border' : '';
        $classes .= $data->stretched ? ' stretched' : '';
        $classes .= $data->withBackground ? ' background' : '';

        return '<img src="' . $data->file->url . '" alt="' . $data->caption . '" class="' . $classes . '"></img>';
    }

    private static function processContent($type, $data)
    {
        $processor = [
            'header' => 'processHeader',
            'paragraph' => 'processParagraph',
            'list' => 'processList',
            'table' => 'processTable',
            'code' => 'processCode',
            'image' => 'processImage'
        ];
        $method = $processor[$type];
        return self::$method($data);
    }



    private static function getCodeHighLighted ($code, $language = null)
    {
        $highlighter = new Highlighter();

        try {

            if ($language != null)
            {
                $highlighted = $highlighter->highlight($language, $code);
            }
            else
            {
                $highlighter->setAutodetectLanguages(self::$langSearchSpace);

                $highlighted = $highlighter->highlightAuto($code);
            }

            return '<pre><code class="hljs ' . $highlighted->language . '">' . $highlighted->value . '</code></pre>';

        }
        catch (\Exception $e) {

            return '<pre><code class="hljs">' . $code . '</code></pre>';
        }
    }
}
