<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Number extends Transformer
{

    protected function transform()
    {
        return number_format($this->get(), 2, ',', ' ');
    }
}
