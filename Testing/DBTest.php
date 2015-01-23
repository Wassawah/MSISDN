<?php

namespace App\Test;

use App\Lookup;

class DBTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providertestGetRowSqlInjection
     */
    public function testGetRowSqlInjection($query, $params = array())
    {
        new Lookup();
        $obj = new \App\DB\Database();

        $result = $obj->getRow($query, $params);

        $this->assertNotEmpty($result);

        print_r($result);
    }

    public function providertestGetRowSqlInjection()
    {
        return array(
            array('SELECT * FROM info WHERE country_code = 386'),
            array('SELECT * FROM info WHERE country_code = 386 OR 1=1'),
            array('SELECT * FROM info WHERE country_code = :value', array('value' => '386 OR 1=1')),
        );
    }

    /**
     * @dataProvider providertestGetRow
     */
    public function testGetRow($query, $expectedResult)
    {
        new Lookup();
        $obj = new \App\DB\Database();

        $result = $obj->getRow($query);

        $this->assertEquals($expectedResult, count($result));
    }

    public function providertestGetRow()
    {
        return array(
            array('SELECT * FROM info', 6),
            array('SELECT ISO FROM info', 1),
            array('SELECT * FROM info WHERE id = 20', 6),
        );
    }
}
