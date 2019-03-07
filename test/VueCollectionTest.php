<?php

namespace mrcrmn\VueGenerator\Tests;

use mrcrmn\VueGenerator\Vue;
use PHPUnit\Framework\TestCase;
use mrcrmn\VueGenerator\VueCollection;

class VueCollectionTest extends TestCase
{
    public function test_it_can_be_instanciated()
    {
        $collection = new VueCollection();

        $this->assertInstanceOf(VueCollection::class, $collection);
    }

    public function test_it_renders_multiple_components()
    {
        $collection = new VueCollection([
            new Vue('v-link'),
            new Vue('v-link')
        ]);

        $this->assertEquals("<v-link></v-link><v-link></v-link>", $collection->render());
    }

    public function test_it_can_be_passed_as_a_slot()
    {
        $outer = Vue::make('v-slider');
        $outer->setProp('autoplay', true);

        $inner  = new VueCollection([
            Vue::make('v-slider-item')->setProp('src', 'image1.jpg'),
            Vue::make('v-slider-item')->setProp('src', 'image2.jpg'),
        ]);

        $outer->setSlot($inner);

        $this->assertEquals("<v-slider v-bind:autoplay='true'><v-slider-item src='image1.jpg'></v-slider-item><v-slider-item src='image2.jpg'></v-slider-item></v-slider>", $outer->render());
    }
}