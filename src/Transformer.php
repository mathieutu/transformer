<?php

namespace MathieuTu\Transformer;

use JsonSerializable;

abstract class Transformer implements JsonSerializable, Arrayable, Jsonable, Serializable
{
    use Helpers;
    use Transformations;

    private $key;
    private $dataToTransform;
    protected $options;

    public static function transform($dataToTransform, $key = null, array $options = [])
    {
        return (new static($dataToTransform, $key, $options))->serialize();
    }

    public function __construct($dataToTransform, $key = null, array $options = [])
    {
        $this->dataToTransform = $dataToTransform;
        $this->key = $key;
        $this->options = $options;
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

    public function getOptions(): array
    {
        return $this->options;
    }

    protected function with(string $transformerClass, $paths = null): Transformer
    {
        return new $transformerClass($this->get($paths), $paths, $this->options);
    }

    abstract protected function map();
}
