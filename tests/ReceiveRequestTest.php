<?php


namespace Miinto\ContextTracing\Tests;


use Miinto\ContextTracing\ContextTracker;
use Miinto\ContextTracing\SimpleTracer;
use PHPUnit\Framework\TestCase;

class ReceiveRequestTest extends TestCase
{
    public function testExtractOperation()
    {
        $operation = 'parent-operation';
        $context = [
            'operation' => $operation
        ];
        $payload = [
            '__meta' => [
                'context' => $context
            ]
        ];

        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext($payload['__meta']['context']);

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'operation' => $operation,
            'items' => [],
            'tags' => [],
        ], $flatData);
    }

    public function testExtractItems()
    {
        $operation = 'parent-operation';
        $items = ['item1' => 'value1', 'item2' => 'value2'];
        $context = [
            'operation' => $operation,
            'items' => $items
        ];
        $payload = [
            '__meta' => [
                'context' => $context,
            ]
        ];

        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext($payload['__meta']['context']);

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'operation' => $operation,
            'items' => $items,
            'tags' => [],
        ], $flatData);
    }

    public function testNoContext()
    {
        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext([]);
    }


}