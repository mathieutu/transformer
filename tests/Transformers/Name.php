<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Name extends Transformer
{
    protected function map()
    {
        return [
            $this->get(['first', 'last'], 'name'),
            'full' => $this->with(FullName::class, ['sex', 'name']),
        ];
    }
}
