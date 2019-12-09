<?php

namespace App;

class ContentConversion
{
    private static $body_json;

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
        $table = '<table><tbody>';
        $content = $data->content;
        foreach ($content as $rows) {
            $table .= '<tr>';
            foreach ($rows as $row) {
                $value = strip_tags($row);
                $table .= '<td>' . $value . '</td>';
            }
            $table .= '<tr>';
        }
        $table .= '</tbody></table>';
        return $table;
    }

    private static function processCode($data)
    {
        return '<code>' . $data->code . '</code>';
    }

    private static function processImage($data)
    {
        return '<img src="' . $data->file->url . '" alt="' . $data->caption . '"></img>';
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
}
