<?php

/**
 * Functions for to iterate string
 *
 * @author USAMI Kenta <tadsan@zonu.me>
 * @copyright 2019 USAMI Kenta
 * @license https://www.mozilla.org/en-US/MPL/2.0/ MPL-2.0
 */
namespace Bag2\iter\string
{
    /**
     * Iterate for each byte of string
     *
     * @param string $string
     * @return \Generator<string>
     */
    function each_byte(string $string)
    {
        $length = \strlen($string);

        for ($i = 0; $i < $length; $i++) {
            yield $string[$i];
        }
    }

    /**
     * Iterate for each character codepoint in UTF-8
     *
     * @param string $string
     * @return \Generator<string>
     */
    function each_codepoint(string $string)
    {
        if (!\preg_match_all('/./su', $string, $matches)) {
            return;
        }

        foreach ($matches[0] as $char) {
            yield $char;
        }
    }

    /**
     * Iterate for each grapheme character
     *
     * @param string $string UTF-8 encoded string
     * @return \Generator<string>
     */
    function each_grapheme(string $string)
    {
        $bytes = \strlen($string);

        for ($pos = $next = 0; $next < $bytes; $pos = $next) {
            $len = 1;
            do {
                $chars = \grapheme_extract($string, $len++, \GRAPHEME_EXTR_MAXCHARS, $pos, $next);
            } while ($pos === $next);

            yield $chars;
        }
    }
}
