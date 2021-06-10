<?php


namespace Miinto\ContextTracing\Tests;


use Miinto\ContextTracing\ContextTracker;
use Miinto\ContextTracing\SimpleTracer;
use PHPUnit\Framework\TestCase;

class TagsTest extends TestCase
{
    public function testAddTags()
    {
        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext(['operation' => 'my-operation']);
        $simpleTracer->addTag('key1', 'value1');
        $simpleTracer->addTag('key2', 'value2');

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'operation' => 'my-operation',
            'items' => [],
            'tags' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ], $flatData);
    }

    public function testTagsStack()
    {
        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext(['operation' => 'my-operation']);
        $simpleTracer->addTag('key1', 'value1');
        $simpleTracer->addTag('key2', 'value2');
        $simpleTracer->startChildSpan('my-sub-operation');
        $simpleTracer->addTag('key3', 'value3');

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'operation' => 'my-operation||my-sub-operation',
            'items' => [],
            'tags' => [
                'key1' => 'value1',
                'key2' => 'value2',
                'key3' => 'value3',
            ],
        ], $flatData);
    }


}