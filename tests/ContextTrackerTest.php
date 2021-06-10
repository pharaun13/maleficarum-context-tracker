<?php


namespace Miinto\ContextTracing\Tests;


use Miinto\ContextTracing\ContextTracker;
use Miinto\ContextTracing\SimpleTracer;
use PHPUnit\Framework\TestCase;

class ContextTrackerTest extends TestCase
{
    public function testFullScenario()
    {
        $tracer = new SimpleTracer();
        $tracer->createSpanFromContext(['operation' => 'my-operation', 'items' => ['item1' => 'value1']]);
        ContextTracker::init($tracer);

        ContextTracker::getTracer()->addTag('tag1', 'value1');
        ContextTracker::getTracer()->addItem('item1', 'itemValue1');

        ContextTracker::getTracer()->startChildSpan('my-sub-operation');

        ContextTracker::getTracer()->addTag('tag2', 'value2');
        ContextTracker::getTracer()->addItem('item2', 'itemValue2');

        ContextTracker::getTracer()->startChildSpan('my-sub-operation2');

        $message = ['data' => ['foo']];
        $messageEnriched = ContextTracker::getTracer()->injectIntoMessage($message);

        $flatData = ContextTracker::getTracer()->flatten();

        $this->assertEquals([
            'operation' => 'my-operation||my-sub-operation||my-sub-operation2',
            'items' => [
                'item1' => 'itemValue1',
                'item2' => 'itemValue2',
            ],
            'tags' => [
                'tag1' => 'value1',
                'tag2' => 'value2',
            ],
        ], $flatData);

        $this->assertEquals([
                'data' => ['foo'],
                '__meta' => [
                    'context' => [
                        'operation' => 'my-operation||my-sub-operation||my-sub-operation2',
                        'items' => [
                            'item1' => 'itemValue1',
                            'item2' => 'itemValue2',
                        ]
                    ]
                ]
            ]
            , $messageEnriched);
    }
}