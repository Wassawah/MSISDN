<?php

namespace App\Test;

use App\Lookup;

class TestLookup extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providertestcleanNumberReturnCleanNumbers
     */
    public function testcleanNumberReturnCleanNumbers($originalString, $expectedResult)
    {
        $lookup = new Lookup;

        $result = $lookup->cleanNumber($originalString);

        $this->assertEquals($expectedResult, $result);
    }

    public function providertestcleanNumberReturnCleanNumbers()
    {
        return array(
            array('', ''),
            array('abchjaskdlčhsa', ''),
            array('1 or 1=1', ''),
            array('12132321 or 1=1', '1213232111'),
            array('+38640514620', '38640514620'),
            array('003fdfdasa8640adsf514asfdas620', '38640514620'),
            array('0fd03fdas8640sfds51462afd01', '00386405146201')
        );
    }

    /**
     * @dataProvider providertestpregReplaceReturnNumbers
     */
    public function testpregReplaceReturnNumbers($what, $with, $string, $expectedResult)
    {
        $lookup = new Lookup;

        $result = $lookup->pregReplace($what, $with, $string);

        $this->assertEquals($expectedResult, $result);
    }

    public function providertestpregReplaceReturnNumbers()
    {
        return array(
            array('/\D/', '', '0038sda64ds0a514ds6ad20', '0038640514620'),
            array('/(^00)/', '', '0038sda64ds0a514ds6ad20', '38sda64ds0a514ds6ad20')
        );
    }

    /**
     * @dataProvider providertestmsisdnReturnArray
     */
    public function testmsisdnReturnArray($number, $expectedResult)
    {
        $lookup = new Lookup;

        $result = $lookup->msisdn($number);

        $this->assertContains($expectedResult, $result);
    }
    public function providertestmsisdnReturnArray()
    {
        return array(
            array('89798979', 'Unknown Country'),
            array('dfa43qa', 'This is not a MSISDN?'),
            array('654534165', 'Unknown NDC'),
            array('0038640544652', 'SI.Mobil'),
        );
    }
}
