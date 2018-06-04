<?php

namespace MathieuTu\Transformer;

use Tightenco\Collect\Support\Arr;

class Collection extends \Tightenco\Collect\Support\Collection implements Serializable
{
    public function parseNested()
    {
        return $this->map(function ($value) {
            if (is_iterable($value)) {
                return static::make($value)->parseNested();
            }

            return $value;
        });
    }

    public function serialize()
    {
        return array_map(function ($value) {
            if ($value instanceof Serializable) {
                return $value->serialize();
            }

            return $value;
        }, $this->items);
    }

    protected function getArrayableItems($items)
    {
        if ($items instanceof Transformer) {
            $items = $items->prepareTransformation();
        }

        return parent::getArrayableItems($items);
    }
}
