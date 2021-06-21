<?php


namespace Maleficarum\ContextTracing\Tests;


use Maleficarum\ContextTracing\Carrier\Http\AmqpHeader;
use Maleficarum\ContextTracing\SimpleTracer;
use PHPUnit\Framework\TestCase;

class ReceiveRequestTest extends TestCase
{
    public function testExtractItems()
    {
        $headers = [
           AmqpHeader::X_MIINTO_CONTEXT_MASTER_ID => 'value1',
           AmqpHeader::X_MIINTO_CONTEXT_LAST_ID => 'value2',
        ];

        $httpHeader = new AmqpHeader();
        $simpleTracer = new SimpleTracer();
        $httpHeader->extract($simpleTracer, $headers);

        $this->assertEquals('value1', $simpleTracer->getItem(SimpleTracer::MASTER_ID));
        $this->assertTrue($simpleTracer->hasItem(SimpleTracer::MASTER_ID));
        $this->assertEquals('value2', $simpleTracer->getItem(SimpleTracer::LAST_ID));
        $this->assertTrue($simpleTracer->hasItem(SimpleTracer::LAST_ID));
    }

    public function testNoContext()
    {
        $headers = [];

        $httpHeader = new AmqpHeader();
        $simpleTracer = new SimpleTracer();
        $httpHeader->extract($simpleTracer, $headers);

        $this->assertFalse($simpleTracer->hasItem(SimpleTracer::MASTER_ID));
        $this->assertFalse($simpleTracer->hasItem(SimpleTracer::LAST_ID));
    }


}