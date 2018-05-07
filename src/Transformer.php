<?php

namespace MathieuTu\Transformer;

use MathieuTu\Exporter\ExporterService;
use Tightenco\Collect\Support\Arr;
use Tightenco\Collect\Support\Collection;

abstract class Transformer implements \JsonSerializable
{
    protected $key;
    private $apiObject;

    public function __construct($apiObject, $key = null)
    {
        $this->apiObject = $apiObject;
        $this->key = $key;
    }

    public static function process($dataToTransform)
    {
        return json_decode(json_encode(new static($dataToTransform)), true);
    }

    public function __toString()
    {
        return (string) $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        if (($data = $this->get()) === null) {
            return $data;
        }

        if (!$this->keep() && \is_string($this->transform())) {
            return $this->transform();
        }

        $this->addCollectionMacros();
        return ExporterService::exportFrom($data, $this->keep())
            ->mergeRecursive($this->getTransformedArray());
    }

    /**
     * @param string[]|string $paths
     *
     * @return mixed
     */
    public function get($path = null, $_ = null)
    {
        if (\is_array($paths = $path) || count($paths = \func_get_args()) > 1) {
            return collect($paths)->mapWithKeys(function ($path) {
                return [$path => data_get($this->apiObject, $path)];
            })->all();
        };

        return data_get($this->apiObject, $path);
    }

    protected function keep(): array
    {
        return [];
    }

    protected function transform()
    {
        return [];
    }

    private function addCollectionMacros(): void
    {
        Collection::macro('mergeRecursive', function ($items) {
            return new static(array_merge_recursive($this->toArray(), $this->getArrayableItems($items)));
        });
    }

    private function getTransformedArray()
    {
        $transformedArray = [];
        foreach ($this->transform() as $key => $value) {
            Arr::set($transformedArray, $key, $value);
        }

        return $transformedArray;
    }

    protected function with(string $transformerClass, $paths = null): Transformer
    {
        return new $transformerClass($this->get($paths));
    }

    protected function withSeveral(string $transformerClass, ?string $key = null): array
    {
        return collect($this->get($key))
            ->mapInto($transformerClass)
            ->mapWithKeys(function (self $transformer) {
                return [$transformer->key() => $transformer];
            })->all();
    }

    public function key()
    {
        return $this->key;
    }
}
