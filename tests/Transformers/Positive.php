<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Positive extends Transformer
{

    protected function map()
    {
        return $this->get() ? '+' : '-';
    }
}
