<?php

namespace App\Converters;

use Highlight\Highlighter;
use Exception;

class EditorJSConverter
{
    private static $body_json;
    private static $langSearchSpace = ['java', 'python', 'javascript', 'php', 'sql'];

    public static function getHtml(array $body_json)
    {
        self::$body_json = $body_json;

        $body_html = '';
        foreach (self::$body_json['blocks'] as $block) {
            $body_html .= self::processContent($block['type'], $block['data']);
        }

        return $body_html;
    }

    private static function processHeader($data)
    {
        $level = isset($data['level']) ? $data['level'] : '3';
        return '<h' .
            $level .
            '>' .
            (isset($data['text']) ? $data['text'] : '') .
            '</h' .
            $level .
            '>';
    }

    private static function processParagraph($data)
    {
        return '<p>' . (isset($data['text']) ? $data['text'] : '') . '</p>';
    }

    private static function processList($data)
    {
        $tag = isset($data['style']) && $data['style'] === 'ordered' ? 'ol' : 'ul';
        $list = '<' . $tag . '>';
        $items = isset($data['items']) ? $data['items'] : [];
        foreach ($items as $item) {
            $list .= '<li>' . $item . '</li>';
        }
        $list .= '</' . $tag . '>';
        return $list;
    }

    private static function processTable($data)
    {
        $table = '<table class="border border-collapse table-auto wt-table"><tbody>';
        $content = isset($data['content']) ? $data['content'] : [];
        foreach ($content as $rows) {
            $table .= '<tr class="wt-table-tr">';
            foreach ($rows as $row) {
                $value = strip_tags($row);
                $table .= '<td class="border py-1 px-2 wt-table-td">' . $value . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</tbody></table>';
        return $table;
    }

    private static function processCode($data)
    {
        return self::getCodeHighLighted($data['code']);
    }

    private static function processImage($data)
    {
        $containerClass = 'my-4';
        $imgClass = '';

        if ($data['stretched']) {
            $containerClass .= ' img-container-stretched ';
            $imgClass = 'img-self-stretched ';
        }

        if ($data['withBackground']) {
            $containerClass .= ' img-container-background';
        }

        if ($data['withBorder']) {
            $imgClass .= 'img-self-border';
        }

        return '<div class="' .
            $containerClass .
            '">' .
            '<figure class="img-fig">' .
            '<img src="' .
            $data['file']['url'] .
            '" alt="' .
            $data['caption'] .
            '" class="' .
            $imgClass .
            '"></img>' .
            '<figcaption class="text-sm mt-3 img-fig-caption' .
            ($data['stretched'] || $data['withBackground'] ? ' text-center' : '') .
            '">' .
            $data['caption'] .
            '</figcaption>' .
            '</figure>' .
            '</div>';
    }

    private static function processEmbeded($data)
    {
        if ($data['service'] == 'youtube') {
            return '<iframe src="' .
                $data['embed'] .
                '" width="' .
                $data['width'] .
                '" height="' .
                $data['height'] .
                '" title="' .
                $data['caption'] .
                '" frameborder="0" allowfullscreen></iframe>';
        } else {
            return '<embed type="' .
                $data['type'] .
                '" src="' .
                $data['source'] .
                '" width="' .
                $data['width'] .
                '" height="' .
                $data['height'] .
                '" title="' .
                $data['caption'] .
                '">';
        }
    }

    private static function processContent($type, $data)
    {
        $processor = [
            'header' => 'processHeader',
            'paragraph' => 'processParagraph',
            'list' => 'processList',
            'table' => 'processTable',
            'code' => 'processCode',
            'image' => 'processImage',
            'embed' => 'processEmbeded',
        ];
        $method = $processor[$type];
        return is_null($data) ? '' : self::$method($data);
    }

    private static function getCodeHighLighted($code, $language = null)
    {
        $highlighter = new Highlighter();

        try {
            if ($language != null) {
                $highlighted = $highlighter->highlight($language, $code);
            } else {
                $highlighter->setAutodetectLanguages(self::$langSearchSpace);

                $highlighted = $highlighter->highlightAuto($code);
            }

            return '<pre><code class="hljs ' .
                $highlighted->language .
                '">' .
                $highlighted->value .
                '</code></pre>';
        } catch (Exception $e) {
            return '<pre><code class="hljs">' . $code . '</code></pre>';
        }
    }
}
