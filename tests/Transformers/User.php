<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class User extends Transformer
{
    public function key()
    {
        return strtolower($this->get('username'));
    }

    protected function map()
    {
        return [
            $this->get(['birthdate']),
            'gender'   => $this->with(Gender::class, 'sex'),
            'name'     => $this->with(Name::class, ['sex', 'name']),
            'email'    => strtolower($this->get('email')),
            'postcode' => $this->with(Integer::class, 'postcode'),
            'balance'  => $this->with(Balance::class, 'balance'),
        ];
    }
}
