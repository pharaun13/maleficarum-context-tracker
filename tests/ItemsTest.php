<?php


namespace Miinto\ContextTracing\Tests;


use Miinto\ContextTracing\ContextTracker;
use Miinto\ContextTracing\SimpleTracer;
use PHPUnit\Framework\TestCase;

class ItemsTest extends TestCase
{
    public function testAddTags()
    {
        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext(['operation' => 'my-operation']);
        $simpleTracer->addItem('key1', 'value1');
        $simpleTracer->addItem('key2', 'value2');

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'operation' => 'my-operation',
            'items' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            'tags' => [
            ],
        ], $flatData);
    }

    public function testItemsStack()
    {
        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext(['operation' => 'my-operation']);
        $simpleTracer->addItem('key1', 'value1');
        $simpleTracer->addItem('key2', 'value2');
        $simpleTracer->startChildSpan('my-sub-operation');
        $simpleTracer->addItem('key3', 'value3');

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'operation' => 'my-operation||my-sub-operation',
            'tags' => [],
            'items' => [
                'key1' => 'value1',
                'key2' => 'value2',
                'key3' => 'value3',
            ],
        ], $flatData);
    }

    public function testItemsAreInjectedIntoMessage()
    {
        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext(['operation' => 'my-operation']);
        $simpleTracer->addItem('key1', 'value1');
        $simpleTracer->addItem('key2', 'value2');
        $simpleTracer->startChildSpan('my-sub-operation');
        $simpleTracer->addItem('key3', 'value3');

        $message = ['data' => 'payload'];
        $enrichedMessage = $simpleTracer->injectIntoMessage($message);

        $this->assertEquals(array_merge($message,
        [
            '__meta' => [
                'context' => [
                    'operation' => 'my-operation||my-sub-operation',
                    'items' => [
                        'key1' => 'value1',
                        'key2' => 'value2',
                        'key3' => 'value3',
                    ],
                ]
            ]
        ]
        ), $enrichedMessage);

        $simpleTracer = new SimpleTracer();
        $simpleTracer->createSpanFromContext($enrichedMessage['__meta']['context']);

        $simpleTracer->addItem('key4', 'value4');

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'operation' => 'my-operation||my-sub-operation',
            'tags' => [],
            'items' => [
                'key1' => 'value1',
                'key2' => 'value2',
                'key3' => 'value3',
                'key4' => 'value4',
            ],
        ], $flatData);
    }
}