<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Integer extends Transformer
{
    protected function transform()
    {
        return number_format($this->get(), 0, '', ' ');
    }
}
