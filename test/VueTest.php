<?php

namespace mrcrmn\VueGenerator\Tests;

use mrcrmn\VueGenerator\Vue;
use PHPUnit\Framework\TestCase;

class VueTest extends TestCase
{
    public function test_it_can_be_created()
    {
        $vue = new Vue('v-template');
        $vueStatic = Vue::make('v-template');

        $this->assertInstanceOf(Vue::class, $vue);
        $this->assertInstanceOf(Vue::class, $vueStatic);
    }

    public function test_props_get_rendered_correctly()
    {
        $vue = new Vue('v-template');
                
        $vue->setProp('bool', true)
            ->setProp('string', 'Hello World')
            ->setProp('number', 420)
            ->setProp('array', [1, 2, 3])
            ->setProp('object', ['one' => 1, 'two' => 2, 'three' => 3]);

        $this->assertEquals("<v-template v-bind:bool='true' string='Hello World' v-bind:number='420' v-bind:array='[1,2,3]' v-bind:object='{\"one\":1,\"two\":2,\"three\":3}'></v-template>", $vue->render());
    }

    public function test_multiple_props_can_be_set()
    {
        $vue = new Vue('v-template');
        $vue->setProp([
            'bool' => true,
            'string' => 'Hello World',
            'number' => 420,
            'array' => [1, 2, 3],
            'object' => ['one' => 1, 'two' => 2, 'three' => 3]
        ]);

        $this->assertEquals("<v-template v-bind:bool='true' string='Hello World' v-bind:number='420' v-bind:array='[1,2,3]' v-bind:object='{\"one\":1,\"two\":2,\"three\":3}'></v-template>", $vue->render());
    }

    public function test_props_can_be_set_conditionally()
    {
        $vue = new Vue('v-template');
        $vue->setProp([
            'bool' => true,
            'string' => 'Hello World',
            'number' => 420,
            'array' => [1, 2, 3],
            'object' => ['one' => 1, 'two' => 2, 'three' => 3]
        ], false)->setProp('ignore-me', 'aswell', false);

        $this->assertEquals("<v-template></v-template>", $vue->render());
    }

    public function test_slots_will_be_rendered_correctly()
    {
        $vue = new Vue('v-outer');
        $vue2 = new Vue('v-inner');
        $vue2->setProp('inside', true);
        $vue->setSlot($vue2->render());

        $this->assertEquals("<v-outer><v-inner v-bind:inside='true'></v-inner></v-outer>", $vue->render());
    }

    public function test_slots_will_be_rendered_when_only_a_renderable_object_is_passed()
    {
        $vue = new Vue('v-outer');
        $vue2 = new Vue('v-inner');
        $vue2->setProp('inside', true);
        $vue->setSlot($vue2);

        $this->assertEquals("<v-outer><v-inner v-bind:inside='true'></v-inner></v-outer>", $vue->render());
    }

    public function test_it_converts_an_array_to_a_vue_collection_when_set_as_a_slot()
    {
        $vue = Vue::make('v-outer')->setSlot([
            Vue::make('v-inner')
        ]);

        $this->assertEquals("<v-outer><v-inner></v-inner></v-outer>", $vue->render());
    }

    public function test_it_accepts_an_array_of_props_as_a_second_argument()
    {
        $vue = Vue::make('v-link', [
            'href' => 'https://www.example.com'
        ]);

        $this->assertEquals("<v-link href='https://www.example.com'></v-link>", $vue->render());
    }

    public function test_it_sets_the_slot_when_the_prop_name_is_slot()
    {
        $vue = Vue::make('v-link', [
            'href' => 'https://www.example.com',
            'slot' => 'Home'
        ]);

        $this->assertEquals("<v-link href='https://www.example.com'>Home</v-link>", $vue->render());
    }

    public function test_it_can_construct_a_instance_from_an_array_structure()
    {
        $nav = [
            'tag' => 'v-nav',
            'slot' => [
                [
                    'tag' => 'v-link',
                    'href' => '/home',
                    'slot' => 'Home',
                ],
                [
                    'tag' => 'v-link',
                    'href' => '/about',
                    'slot' => 'About'
                ]
            ]
        ];

        $vue = Vue::construct($nav);

        $this->assertEquals("<v-nav><v-link href='/home'>Home</v-link><v-link href='/about'>About</v-link></v-nav>", $vue->render());
    }
}