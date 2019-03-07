<?php

namespace mrcrmn\VueGenerator\Tests;

use PHPUnit\Framework\TestCase;
use mrcrmn\VueGenerator\HtmlTag;

class HtmlTagTest extends TestCase
{
    public function test_it_can_be_created()
    {
        $html = new HtmlTag('div');
        $htmlStatic = HtmlTag::make('div');

        $this->assertInstanceOf(HtmlTag::class, $html);
        $this->assertInstanceOf(HtmlTag::class, $htmlStatic);
    }

    public function test_it_can_return_its_tagname()
    {
        $html = HtmlTag::make('div');
        
        $this->assertEquals('div', $html->getTagName());
    }

    public function test_it_can_render_basic_html()
    {
        $html = HtmlTag::make('div');

        $this->assertEquals('<div></div>', $html->render());
    }
    
    public function test_the_tostring_implementation_renders_the_html()
    {
        $html = HtmlTag::make('div');
        
        $this->assertEquals('<div></div>', $html->__toString());
    }

    public function test_it_correctly_renders_self_closing_tags()
    {
        $html = HtmlTag::make('img');

        $this->assertEquals('<img>', $html->render());
    }

    public function test_it_renders_basic_attributes()
    {
        $html = HtmlTag::make('img');

        $html->setAttribute('src', 'https://example.com/image.jpg');

        $this->assertEquals('<img src="https://example.com/image.jpg">', $html->render());
    }

    public function test_it_renders_multiple_basic_attributes()
    {
        $html = HtmlTag::make('img');

        $html->setAttribute('src', 'https://example.com/image.jpg')
             ->setAttribute('alt', 'Alt Text');

        $this->assertEquals('<img src="https://example.com/image.jpg" alt="Alt Text">', $html->render());

        $html = HtmlTag::make('img');

        $html->setAttribute('src', 'https://example.com/image.jpg')
             ->setAttribute('alt', 'Alt Text', false);

        $this->assertEquals('<img src="https://example.com/image.jpg">', $html->render());
    }

    public function test_you_can_pass_an_array_to_the_attributes()
    {
        $html = HtmlTag::make('img');

        $html->setAttribute([
            'src' => 'https://example.com/image.jpg',
            'alt' => 'Alt Text'
        ]);

        $this->assertEquals('<img src="https://example.com/image.jpg" alt="Alt Text">', $html->render());

        $html = HtmlTag::make('img');

        $html->setAttribute([
            'src' => 'https://example.com/image.jpg',
            'alt' => 'Alt Text'
        ], false);

        $this->assertEquals('<img>', $html->render());
    }

    public function test_it_can_render_a_slot()
    {
        $html = HtmlTag::make('h1');
        
        $html->setAttribute('class', 'bold')->setSlot('Hallo Welt');

        $this->assertEquals('<h1 class="bold">Hallo Welt</h1>', $html->render());
    }

    public function test_it_can_render_a_renderable_slot()
    {
        $html = HtmlTag::make('h1')->setSlot(
            HtmlTag::make('span')->setSlot('inner text')
        );
    
        $this->assertEquals('<h1><span>inner text</span></h1>', $html->render());
    }
}