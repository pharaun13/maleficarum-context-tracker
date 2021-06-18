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
        $simpleTracer->addTag('key1', 'value1');
        $simpleTracer->addTag('key2', 'value2');

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'tags' => [
                SimpleTracer::MASTER_ID => null,
                SimpleTracer::CURRENT_ID => null,
                SimpleTracer::LAST_ID => null,
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ], $flatData);
    }

    public function testAddTagsAndIds()
    {
        $simpleTracer = new SimpleTracer();
        $simpleTracer->addItem(SimpleTracer::MASTER_ID, 'master_id');
        $simpleTracer->addItem(SimpleTracer::LAST_ID, 'last_id');
        $simpleTracer->addItem(SimpleTracer::CURRENT_ID, 'current_id');
        $simpleTracer->addTag('key1', 'value1');
        $simpleTracer->addTag('key2', 'value2');

        $flatData = $simpleTracer->flatten();

        $this->assertEquals([
            'tags' => [
                SimpleTracer::MASTER_ID => 'master_id',
                SimpleTracer::CURRENT_ID => 'current_id',
                SimpleTracer::LAST_ID => 'last_id',
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ], $flatData);
    }

}