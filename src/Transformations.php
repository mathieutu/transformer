<?php

namespace MathieuTu\Transformer;

trait Transformations
{
    public function serialize()
    {
        $serialized = $this->prepareTransformation();

        if ($serialized instanceof Serializable) {
            return $serialized->serialize();
        };

        return $serialized;
    }

    public function toArray(): array
    {
        $serialized = $this->prepareTransformation();

        if ($serialized instanceof Collection) {
            return $serialized->toArray();
        };

        return (array) $serialized;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this, $options);
    }

    public function __toString()
    {
        return (string) $this->prepareTransformation();
    }

    public function jsonSerialize()
    {
        return $this->prepareTransformation();
    }
}
