<?php

namespace MathieuTu\Transformer\Tests;

use MathieuTu\Transformer\Tests\Transformers\Integer;
use MathieuTu\Transformer\Tests\Transformers\Number;
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
            Users::process($this->getSourceArray())
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
        $this->assertEquals(null, User::process(null));
    }

    public function testTransformerWithNoTransformedAttributes()
    {
        $transformer = new class([]) extends Transformer
        {
            protected function keep(): array
            {
                return ['foo'];
            }
        };

        $this->assertEquals(
            ["foo" => "testFoo"],
            $transformer::process(['foo' => 'testFoo', 'bar' => 'testBar'])
        );
    }

    public function testTransformingArrayandKeepingKeys()
    {
        $transformer = new class([]) extends Transformer
        {
            protected function transform()
            {
                return $this->withSeveral(Integer::class);
            }
        };

        $this->assertSame(
            ['Iwazaru' => '134', 'cl' => '212'],
            $transformer::process(['Iwazaru' => 134, 'cl' => 212])
        );
    }

}
