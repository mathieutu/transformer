<?php

namespace MathieuTu\Transformer;

use JsonSerializable;

abstract class Transformer implements JsonSerializable, Arrayable, Jsonable, Serializable
{
    use Helpers;
    use Transformations;

    private $key;
    private $dataToTransform;

    public function __construct($dataToTransform, $key = null)
    {
        $this->dataToTransform = $dataToTransform;
        $this->key = $key;
    }


    public function prepareTransformation()
    {
        if ($this->dataToTransform === null) {
            return $this->dataToTransform;
        }

        $toTransform = $this->map();

        if (!is_iterable($toTransform)) {
            return $toTransform;
        }

        $merged = Collection::make();
        foreach ($toTransform as $key => $value) {
            $merged = $merged->merge(\is_int($key) ? $value : [$key => $value]);
        }

        return $merged->parseNested();
    }

    abstract protected function map();
}
