<?php

namespace Bag2\iter\string;

use function Bag2\iter\string\each_byte;

/**
 * Test for to iterate string
 *
 * @author USAMI Kenta <tadsan@zonu.me>
 * @copyright 2019 USAMI Kenta
 * @license https://www.mozilla.org/en-US/MPL/2.0/ MPL-2.0
 */
final class EachByteTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test($input, $expected)
    {
        $actual = each_byte($input);

        $this->assertSame($expected, \iterator_to_array($actual));
    }

    public function dataProvider()
    {
        $zwj = "\u{200D}";

        return [
            ['', []],
            ['a', ['a']],
            ['あ', ['あ'[0], 'あ'[1], 'あ'[2]]],
            ['ああ', ['あ'[0], 'あ'[1], 'あ'[2], 'あ'[0], 'あ'[1], 'あ'[2]]],
            ['👪', ['👪'[0], '👪'[1], '👪'[2], '👪'[3]]],
            ["a\nb", ['a', "\n", 'b']],
            ['👨‍👩‍👦‍👦',
             [
                 '👨'[0], '👨'[1], '👨'[2], '👨'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👩'[0], '👩'[1], '👩'[2], '👩'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👦'[0], '👦'[1], '👦'[2], '👦'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👦'[0], '👦'[1], '👦'[2], '👦'[3],
             ]],
            ['👨‍👨‍👦‍👦👨‍👩‍👦‍👦👩‍👩‍👦‍👦',
             [
                 '👨'[0], '👨'[1], '👨'[2], '👨'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👨'[0], '👨'[1], '👨'[2], '👨'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👦'[0], '👦'[1], '👦'[2], '👦'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👦'[0], '👦'[1], '👦'[2], '👦'[3],
                 '👨'[0], '👨'[1], '👨'[2], '👨'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👩'[0], '👩'[1], '👩'[2], '👩'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👦'[0], '👦'[1], '👦'[2], '👦'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👦'[0], '👦'[1], '👦'[2], '👦'[3],
                 '👩'[0], '👩'[1], '👩'[2], '👩'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👩'[0], '👩'[1], '👩'[2], '👩'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👦'[0], '👦'[1], '👦'[2], '👦'[3],
                 $zwj[0], $zwj[1], $zwj[2],
                 '👦'[0], '👦'[1], '👦'[2], '👦'[3],
             ]],
        ];
    }
}
