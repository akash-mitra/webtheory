<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Converters\ContentsConverter;

class PageContent extends Model
{
    protected $fillable = [
        'page_id', 
        'body_json', 
        'body_html', 
        'type', 
        'display_order'
    ];

    public function page()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    public static function addOrModify(Page $page, $pagecontent)
    {
        if (! isset($pagecontent['id'])) {
            $converter = new ContentsConverter($pagecontent['body_json'], $pagecontent['type']);

            $content = new PageContent([
                'page_id' =>$page->id,
                'body_json' => $pagecontent['body_json'],
                'body_html' => $converter->getHtml(),
                'type' => $pagecontent['type'],
                'display_order' => $pagecontent['display_order']
            ]);
    
            $content->save();
        } else {
            $content = PageContent::findOrFail($pagecontent['id']);
            
            if (! (isset($pagecontent['changed']) && $pagecontent['changed'] === false)) {
                $converter = new ContentsConverter($pagecontent['body_json'], $pagecontent['type']);

                $content->fill([
                    'body_json' => $pagecontent['body_json'],
                    'body_html' => $converter->getHtml(),
                    'type' => $pagecontent['type'],
                    'display_order' => $pagecontent['display_order']
                ])->save();
            }
        }
    }
}
