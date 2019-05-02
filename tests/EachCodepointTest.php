<?php

namespace Bag2\iter\string;

use function Bag2\iter\string\each_codepoint;

/**
 * Test for to iterate string
 *
 * @author USAMI Kenta <tadsan@zonu.me>
 * @copyright 2019 USAMI Kenta
 * @license https://www.mozilla.org/en-US/MPL/2.0/ MPL-2.0
 */
final class EachCodepointTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test($input, $expected)
    {
        $actual = each_codepoint($input);

        $this->assertSame($expected, \iterator_to_array($actual));
    }

    public function dataProvider()
    {
        $zwj = "\u{200D}";

        return [
            ['', []],
            ['a', ['a']],
            ['あ', ['あ']],
            ['ああ', ['あ', 'あ']],
            ['ｶﾞｷﾞｸﾞｹﾞｺﾞ', ['ｶ', 'ﾞ', 'ｷ', 'ﾞ', 'ｸ', 'ﾞ', 'ｹ', 'ﾞ', 'ｺ', 'ﾞ']],
            ['👪', ['👪']],
            ["a\nb", ['a', "\n", 'b']],
            ['👨‍👩‍👦‍👦', ['👨', $zwj, '👩', $zwj, '👦', $zwj, '👦']],
            ['👨‍👨‍👦‍👦👨‍👩‍👦‍👦👩‍👩‍👦‍👦', [
                '👨', $zwj, '👨', $zwj, '👦', $zwj, '👦',
                '👨', $zwj, '👩', $zwj, '👦', $zwj, '👦',
                '👩', $zwj, '👩', $zwj, '👦', $zwj, '👦'
            ]],
        ];
    }
}
