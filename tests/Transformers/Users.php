<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class Users extends Transformer
{
    protected function transform()
    {
        return [
            "users" => $this->withSeveral(User::class, 'rows')
        ];
    }
}
