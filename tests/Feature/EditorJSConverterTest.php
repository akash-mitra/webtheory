<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Converters\ContentsConverter;

class EditorJSConverterTest extends TestDataSetup
{
    private $editor = 'editorjs';

    // Heading
    public function test_header()
    {
        $body_json = '{"blocks": [{"type": "header", "data": {"level": 1,"text": "Test Heading"}}]}';
        $body_html = '<h1>Test Heading</h1>';
        $converter = new ContentsConverter($body_json, $this->editor);
        $response = $converter->getHtml();

        $this->assertEquals($body_html, $response);
    }

    // Paragraph
    public function test_paragraph()
    {
        $body_json = '{"blocks": [{"type": "paragraph", "data": {"text": "Test Paragraph"}}]}';
        $body_html = '<p>Test Paragraph</p>';
        $converter = new ContentsConverter($body_json, $this->editor);
        $response = $converter->getHtml();

        $this->assertEquals($body_html, $response);
    }

    // List
    public function test_list()
    {
        $body_json = '{"blocks": [{"type": "list", "data": {"style": "ordered", "items": ["Item 1","Item 2","Item 3"]}}]}';
        $body_html = '<ol><li>Item 1</li><li>Item 2</li><li>Item 3</li></ol>';
        $converter = new ContentsConverter($body_json, $this->editor);
        $response = $converter->getHtml();

        $this->assertEquals($body_html, $response);
    }

    // Table
    public function test_table()
    {
        $body_json = '{"blocks": [{"type": "table", "data": {"content": [["Item 1","Item 2","Item 3"]]}}]}';
        $body_html = '<table class="border border-collapse wt-table"><tbody><tr class="wt-table-tr"><td class="border px-2 wt-table-td">Item 1</td><td class="border px-2 wt-table-td">Item 2</td><td class="border px-2 wt-table-td">Item 3</td></tr></tbody></table>';
        $converter = new ContentsConverter($body_json, $this->editor);
        $response = $converter->getHtml();

        $this->assertEquals($body_html, $response);
    }

    // Code
    public function test_code()
    {
        $body_json = '{"blocks": [{"type": "code", "data": {"code": "SELECT * FROM users"}}]}';
        $body_html = '<pre><code class="hljs sql"><span class="hljs-keyword">SELECT</span> * <span class="hljs-keyword">FROM</span> <span class="hljs-keyword">users</span></code></pre>';
        $converter = new ContentsConverter($body_json, $this->editor);
        $response = $converter->getHtml();

        $this->assertEquals($body_html, $response);
    }

    // Image
    public function test_image()
    {
        $body_json = '{"blocks": [{"type": "image", "data": {"file": {"id": 1,"path": "media/test.png", "url": "/storage/media/test.png"}, "caption": "Test Image", "withBorder": false, "stretched": false, "withBackground": false}}]}';
        $body_html = '<div class="my-4"><figure class="img-fig"><img src="/storage/media/test.png" alt="Test Image" class=""></img><figcaption class="text-sm mt-3 img-fig-caption">Test Image</figcaption></figure></div>';
        $converter = new ContentsConverter($body_json, $this->editor);
        $response = $converter->getHtml();

        $this->assertEquals($body_html, $response);
    }

    // Embed
    public function test_embed()
    {
        $body_json = '{"blocks": [{"type": "embed", "data": {"service": "embed", "type": "video/mpeg", "source": "http://example.com/testvideo.mpeg", "width": 100, "height": 100, "caption": "Test Video"}}]}';
        $body_html = '<embed type="video/mpeg" src="http://example.com/testvideo.mpeg" width="100" height="100" title="Test Video">';
        $converter = new ContentsConverter($body_json, $this->editor);
        $response = $converter->getHtml();

        $this->assertEquals($body_html, $response);
    }
}