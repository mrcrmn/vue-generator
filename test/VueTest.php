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
}