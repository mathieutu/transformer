<?php

namespace MathieuTu\Transformer;

trait Helpers
{
    protected function with(string $transformerClass, $paths = null): Transformer
    {
        return new $transformerClass($this->get($paths), $paths);
    }

    /**
     * @param string[]|string $path
     * @param string $nestedIn
     *
     * @return mixed
     */
    protected function get($path = null, ?string $nestedIn = null)
    {
        if (\is_array($paths = $path)) {
            return Collection::make($paths)->mapWithKeys(function ($path, $key) use ($nestedIn) {
                return [\is_int($key) ? $path : $key => $this->get($path, $nestedIn)];
            })->all();
        };

        return data_get($this->dataToTransform, $nestedIn ? "$nestedIn.$path" : $path);
    }

    protected function withSeveral(string $transformerClass, ?string $path = null): Collection
    {
        return $this->getAsCollection($path)
            ->mapInto($transformerClass)
            ->mapWithKeys(function (self $transformer) {
                return [$transformer->key() => $transformer];
            });
    }

    protected function getAsCollection($path = null): Collection
    {
        return new Collection($this->get($path));
    }

    public function key()
    {
        return $this->key;
    }
}
