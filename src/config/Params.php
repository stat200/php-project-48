<?php

namespace Config;

function getParams(): \Closure
{
    return fn() => require(__DIR__ . '/Common.php');
}
