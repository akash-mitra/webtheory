<?php

namespace App;

use App\Converters\ContentsConverter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\PageContent
 *
 * @property int $id
 * @property int $page_id
 * @property object|null $body_json
 * @property string $body_html
 * @property string|null $type
 * @property int $display_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Page $page
 * @method static Builder|PageContent newModelQuery()
 * @method static Builder|PageContent newQuery()
 * @method static Builder|PageContent query()
 * @method static Builder|PageContent whereBodyHtml($value)
 * @method static Builder|PageContent whereBodyJson($value)
 * @method static Builder|PageContent whereCreatedAt($value)
 * @method static Builder|PageContent whereDisplayOrder($value)
 * @method static Builder|PageContent whereId($value)
 * @method static Builder|PageContent wherePageId($value)
 * @method static Builder|PageContent whereType($value)
 * @method static Builder|PageContent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
