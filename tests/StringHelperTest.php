<?php

use PHPUnit\Framework\TestCase;
use Foobarology\SampleLib\StringHelper;

final class StringHelperTest extends TestCase
{

    public function testExcerpt()
    {
        $text = "lorem ipsum dolor sit amet";

        $result = StringHelper::excerpt($text, 3, "..");
        $expected = "lorem ipsum dolor..";

        $this->assertEquals($expected, $result);
    }

}