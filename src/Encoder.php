<?php

namespace GenDiff\Encoder;

function getEncoder(string $encoderType): callable
{
    return encoders()[$encoderType];
}

function encoders(): array
{
    return [
        'json' => function ($encodeStr) {
            return json_encode($encodeStr, JSON_THROW_ON_ERROR, 2);
        }
    ];
}
