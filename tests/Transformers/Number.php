<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Number extends Transformer
{

    protected function map()
    {
        return number_format($this->get(), 2, ',', ' ');
    }
}
