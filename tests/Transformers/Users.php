<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Users extends Transformer
{
    protected function map()
    {
        return [
            "users" => $this->withSeveral(User::class, 'rows')
        ];
    }
}
