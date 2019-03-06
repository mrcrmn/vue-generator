<?php

namespace mrcrmn\VueGenerator\Tests;

use mrcrmn\VueGenerator\Vue;
use PHPUnit\Framework\TestCase;

class VueTest extends TestCase
{
    public function test_it_can_be_created()
    {
        $html = new Vue('v-template');
        $htmlStatic = Vue::make('v-template');

        $this->assertInstanceOf(Vue::class, $html);
        $this->assertInstanceOf(Vue::class, $htmlStatic);
    }

    public function test_props_get_rendered_correctly()
    {
        $html = new Vue('v-template');
                
        $html->addProp('bool', true)
             ->addProp('string', 'Hello World')
             ->addProp('number', 420)
             ->addProp('array', [1, 2, 3])
             ->addProp('object', ['one' => 1, 'two' => 2, 'three' => 3]);

        $this->assertEquals("<v-template v-bind:bool='true' string='Hello World' v-bind:number='420' v-bind:array='[1,2,3]' v-bind:object='{\"one\":1,\"two\":2,\"three\":3}'></v-template>", $html->render());
    }
}