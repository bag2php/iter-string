<?php

namespace Bag2\iter\string;

use function Bag2\iter\string\each_grapheme;

/**
 * Test for to iterate string
 *
 * @author USAMI Kenta <tadsan@zonu.me>
 * @copyright 2019 USAMI Kenta
 * @license https://www.mozilla.org/en-US/MPL/2.0/ MPL-2.0
 */
final class EachGraphemeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test($input, $expected)
    {
        $actual = each_grapheme($input);

        $this->assertSame($expected, iterator_to_array($actual));
    }

    public function dataProvider()
    {
        return [
            ['', []],
            ['a', ['a']],
            ['あ', ['あ']],
            ['ああ', ['あ', 'あ']],
            ['ｶﾞｷﾞｸﾞｹﾞｺﾞ', ['ｶﾞ', 'ｷﾞ', 'ｸﾞ', 'ｹﾞ', 'ｺﾞ']],
            ['👪', ['👪']],
            ["a\nb", ['a', "\n", 'b']],
            ['👨‍👩‍👦‍👦', ['👨‍👩‍👦‍👦']],
            ['👨‍👨‍👦‍👦👨‍👩‍👦‍👦👩‍👩‍👦‍👦', ['👨‍👨‍👦‍👦', '👨‍👩‍👦‍👦', '👩‍👩‍👦‍👦']],
        ];
    }
}
