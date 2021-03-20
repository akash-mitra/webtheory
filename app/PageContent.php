<?php

namespace App;

use App\Converters\ContentsConverter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageContent extends Model
{
    protected $fillable = ['page_id', 'body_json', 'body_html', 'type', 'display_order'];

    // Automatically cast body_json field as an object
    // beauty of Laravel :)
    protected $casts = [
        'body_json' => 'object',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    /**
     * Adds a given content to the page. If the content contains an ID field, then
     * the existing content of the ID is updated.
     *
     * @param Page $page
     * @param $content
     */
    public static function addOrModify(Page $page, $content)
    {
        if (!isset($content['id'])) {
            // add new content
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
            // update existing content
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
