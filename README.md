# Bag2 String Iterator (`\Bag2\iter\string`)

Functions for to iterate string/bytes.

## Functions

### `each_byte`

Use this function specifically to iterate byte by byte.

**NOTICE**: In UTF-8, one character is not one byte.

```php
<?php

use function Bag2\iter\string\each_byte;

$string = "abcdef";

foreach (each_byte($string) as $s) {
    echo $s, PHP_EOL;
}
// a
// b
// c
// d
// e
```

### `each_codepoint`

This function iterates elements of a string at each Unicode [Code point].

**NOTICE**: Input assumes UTF-8 encoded string.

```php
<?php

use function Bag2\iter\string\each_codepoint;

$string = "一二三123あいうABC가나다";

foreach (each_codepoint($string) as $s) {
    echo $s, PHP_EOL;
}
// 一
// 二
// 三
// 1
// 2
// 3
// あ
// い
// う
// A
// B
// C
// 가
// 나
// 다
```

### `each_grapheme`

This function iterates elements of a string at each Unicode [Code point].

**NOTICE**: Input assumes UTF-8 encoded string.

```php
<?php

use function Bag2\iter\string\each_grapheme;

$string = "一二三123あいうABC가나다";

foreach (each_grapheme($string) as $s) {
    echo $s, PHP_EOL;
}
```

## Copyright

**Bag2 String Iterator** is [free software], this package is licensed under [Mozilla Public License Version 2.0][mpl-2.0].

> Bag2\iter\string - Functions for to iterate string/bytes
>
> (C) Copyright  2019 USAMI Kenta <tadsan@zonu.me>
>
> This Source Code Form is subject to the terms of the Mozilla Public
> License, v. 2.0. If a copy of the MPL was not distributed with this
> file, You can obtain one at https://mozilla.org/MPL/2.0/ .

[free software]: https://www.gnu.org/philosophy/free-sw.html
[mpl-2.0]: https://www.mozilla.org/en-US/MPL/2.0/
[Code point]: https://en.wikipedia.org/wiki/Code_point
