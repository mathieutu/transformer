<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class FullName extends Transformer
{

    protected function map()
    {
        return ($this->get('sex') === 'f' ? 'Miss' : 'Mr')
            . ' ' . $this->get('name.first')
            . ' ' . $this->get('name.last');
    }
}
