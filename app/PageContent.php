<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Converters\ContentsConverter;

class PageContent extends Model
{
    protected $fillable = ['page_id', 'body_json', 'body_html', 'type', 'display_order'];

    protected $casts = [
        'body_json' => 'object', // beauty of Laravel :)
    ];

    public function page()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    public static function addOrModify(Page $page, $content)
    {
        if (!isset($content['id'])) {
            $converter = new ContentsConverter($content['body_json'], $content['type']);

            $pageContent = new PageContent([
                'page_id' => $page->id,
                'body_json' => $content['body_json'],
                'body_html' => $converter->getHtml(),
                'type' => $content['type'],
                'display_order' => $content['display_order'],
            ]);

            $pageContent->save();
        } else {
            if (isset($content['changed']) && $content['changed'] === true) {
                $converter = new ContentsConverter($content['body_json'], $content['type']);

                $pageContent = PageContent::findOrFail($content['id']);

                $pageContent
                    ->fill([
                        'body_json' => $content['body_json'],
                        'body_html' => $converter->getHtml(),
                        'type' => $content['type'],
                        'display_order' => $content['display_order'],
                    ])
                    ->save();
            }
        }
    }
}
