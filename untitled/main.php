<?php

$a = 1;
function test() {
    $a = 2;
    echo $a;
}
test($a);
echo $a;