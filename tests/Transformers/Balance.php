<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Balance extends Transformer
{

    protected function map()
    {
        return $this->with(Positive::class, 'positive')
            . ' '
            . $this->with(Number::class, 'value')
            . ' €';
    }
}
