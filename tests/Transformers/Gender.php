<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Gender extends Transformer
{
    private const GENDERS = [
        'm' => ['label' => 'Male', 'value' => 1],
        'f' => ['label' => 'Female', 'value' => 2],
    ];
    protected function transform()
    {
        return self::GENDERS[$this->get()];
    }
}
