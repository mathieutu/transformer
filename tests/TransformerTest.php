<?php

namespace MathieuTu\Transformer\Tests;

use MathieuTu\Transformer\Tests\Transformers\Integer;
use MathieuTu\Transformer\Tests\Transformers\User;
use MathieuTu\Transformer\Tests\Transformers\Users;
use MathieuTu\Transformer\Transformer;
use PHPUnit\Framework\TestCase;

class TransformerTest extends TestCase
{
    public function testTransformationProcessing()
    {
        $this->assertEquals(
            $this->getDestinationArray(),
            Users::transform($this->getSourceArray())
        );
    }

    private function getDestinationArray()
    {
        return $this->getArrayFromJsonFile('destination.json');
    }

    private function getArrayFromJsonFile($file)
    {
        return json_decode(file_get_contents(__DIR__ . '/' . $file), true);
    }

    private function getSourceArray()
    {
        return $this->getArrayFromJsonFile('source.json');
    }

    public function testJsonTransformation()
    {
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/destination.json',
            json_encode(new Users($this->getSourceArray()))
        );
    }

    public function testTransformationToString()
    {
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/destination.json',
            (string) new Users($this->getSourceArray())
        );
    }

    public function testTransformNullValue()
    {
        $this->assertEquals(null, User::transform(null));
    }


    public function testGetMethod()
    {
        $transformer = new class([
            'nested1' => ['foo' => 'testFoo1', 'bar' => 'testBar1'],
            'nested2' => ['foo' => 'testFoo2', 'bar' => 'testBar2'],
        ]) extends Transformer
        {
            protected function map()
            {
            }

            public function publicGet(...$args)
            {
                return parent::get(...$args);
            }
        };

        $this->assertEquals(
            ['foo' => 'testFoo1', 'bar' => 'testBar1'],
            $transformer->publicGet('nested1')
        );

        $this->assertEquals(
            'testFoo1',
            $transformer->publicGet('nested1.foo')
        );

        $this->assertEquals(
            ['nested1.foo' => 'testFoo1', 'test' => null],
            $transformer->publicGet(['nested1.foo', 'test'])
        );
    }

    public function testTransformingArrayAndKeepingKeys()
    {
        $transformer = new class([]) extends Transformer
        {
            protected function map()
            {
                return $this->withSeveral(Integer::class);
            }
        };

        $this->assertSame(
            ['Iwazaru' => '134', 'cl' => '212'],
            $transformer::transform(['Iwazaru' => 134, 'cl' => 212])
        );
    }
}
