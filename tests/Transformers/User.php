<?php

namespace MathieuTu\Transformer\Tests\Transformers;

use MathieuTu\Transformer\Transformer;

class User extends Transformer
{
    public function key()
    {
        return strtolower($this->get('username'));
    }

    protected function keep(): array
    {
        return [
            'birthdate',
            'name' => ['first', 'last'],
        ];
    }

    protected function transform()
    {
        return [
            'gender'    => $this->with(Gender::class, 'sex'),
            'name.full' => $this->with(FullName::class, ['sex', 'name']),
            'email'     => strtolower($this->get('email')),
            'postcode'  => $this->with(Integer::class, 'postcode'),
            'balance' => $this->with(Balance::class, 'balance'),
        ];
    }
}
