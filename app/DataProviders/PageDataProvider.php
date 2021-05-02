<?php

namespace App\DataProviders;

use App\DataProviders\Common\BaseDataProvider;
use App\DataProviders\Common\Renderable\HTMLRenderable;
use App\Page;

class PageDataProvider extends BaseDataProvider implements HTMLRenderable
{
    private Page $page;

    public function __construct($id)
    {
        $this->page = Page::findOrFail($id);
    }

    public function page(): Page
    {
        return $this->page;
    }

    function type(): string
    {
        return 'page';
    }

    public function html(): string
    {
        return '<h1 id="wt-page-title">' . $this->page->title . '</h1>'
            . '<div id="wt-page-summary">' . $this->page->summary . '</div>'
            . '<div id="wt-page-author">' . $this->page->summary . '</div>'
            . '<div id="wt-page-contents">'
            . $this->htmlContents()
            . '</div>';
    }

    function title(): string
    {
        return $this->page->title;
    }

    function description(): string
    {
        return $this->page->metadesc;
    }

    function tags(): string
    {
        return $this->page->metakey;
    }

    function url(): string
    {
        return $this->page->url;
    }

    function image(): string
    {
        return $this->page->media->url;
    }

    private function htmlContents(): string
    {
        $index = 1;
        $html = '';
        foreach($this->page->contents as $content) {
            $html .= '<div class="wt-page-content-items" id="wt-page-content-' . $index . '">'
                . $content->body_html
                . '</div>';
            $index++;
        }
        return $html;
    }
}
