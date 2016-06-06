<?php

use COREPOS\pos\lib\FormLib;

class Test extends PHPUnit_Framework_TestCase
{
    public function testPlugin()
    {
        $obj = new PriceCheck();
    }

    public function testParser()
    {
        $p = new PriceCheckParser();
        $this->assertEquals(true, $p->check('PC'));
        $this->assertEquals(true, $p->check('PC1234'));
        $this->assertEquals(false, $p->check('Foo'));
        $json = $p->parse('PC');
        $this->assertNotEquals(false, strstr($json['main_frame'], 'PriceCheckPage'));
    }

    public function testPages()
    {
        $page = new PriceCheckPage();
        $this->assertEquals(true, $page->preprocess());
        FormLib::set('reginput', 'CL');
        $this->assertEquals(false, $page->preprocess());
        $item = array(
            'inUse'=>1,
            'upc'=>'0000000000000',
            'description'=>'Foo',
            'normal_price'=>1,
            'scale'=>1,
            'deposit'=>1,
            'qttyEnforced'=>1,
            'department'=>1,
            'local'=>1,
            'cost'=>1,
            'tax'=>1,
            'foodstamp'=>1,
            'discount'=>1,
            'discounttype'=>1,
            'specialpricemethod'=>1,
            'special_price'=>1,
            'groupprice'=>1,
            'pricemethod'=>1,
            'quantity'=>1,
            'specialgroupprice'=>1,
            'specialquantity'=>1,
            'mixmatchcode'=>1,
            'idEnforced'=>1,
            'tare_weight'=>1,
            'dept_name'=>'Foo',
        );
        SQLManager::addResult($item);
        FormLib::set('reginput', '1234');
        $this->assertEquals(true, $page->preprocess());
        SQLManager::addResult($item);
        FormLib::set('reginput', '');
        FormLib::set('upc', '1234');
        $this->assertEquals(false, $page->preprocess());
    }
}

