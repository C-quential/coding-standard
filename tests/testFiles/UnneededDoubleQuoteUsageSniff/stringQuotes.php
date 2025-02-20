<?php

$foo = 1;
$bar = 2;

$string = "This is one way to append " . $foo;
$string = "This is another way to append $foo";
$string = 'We could also append ' . $bar;
$string = "Or we could put it here {$bar}";
$string2 = "This shouldn't be allowed either.";
$string = 'And now a lie: this shouldn\'t again.';
$string = 'This is fine "Right?"';