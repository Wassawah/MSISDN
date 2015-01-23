<?php

namespace App\Test;

use App\Lookup;

class ToolsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providertestcheckQuery
     */
    public function testcheckQuery($number)
    {
        new Lookup();

        $obj = new \App\Tools\Hammer();

        $obj->value = $number;
        $obj->checkQuery();

        print_r($obj->result);

        $obj->cleanUp();
        $this->assertEmpty($obj->result);
    }

    public function providertestcheckQuery()
    {
        return array(
            array('386'),
            array('40'),
            array('89'),
        );
    }

    /**
     * @dataProvider providertestcheckQueryNdc
     */
    public function testcheckQueryNdc($number)
    {
        new Lookup();

        $obj = new \App\Tools\Hammer();

        $obj->value = '386';
        $obj->valueNdc = $number;
        $obj->checkQuery();

        print_r($obj->result);

        $obj->cleanUp();
        $this->assertEmpty($obj->result);
    }

    public function providertestcheckQueryNdc()
    {
        return array(
            array('40'),
            array('41'),
            array('89'),
        );
    }
}
