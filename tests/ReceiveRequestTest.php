<?php


namespace Miinto\ContextTracing\Tests;


use Miinto\ContextTracing\Carrier\Http\HttpHeader;
use Miinto\ContextTracing\SimpleTracer;
use PHPUnit\Framework\TestCase;

class ReceiveRequestTest extends TestCase
{
    public function testExtractItems()
    {
        $headers = [
           HttpHeader::X_MIINTO_CONTEXT_MASTER_ID => 'value1',
           HttpHeader::X_MIINTO_CONTEXT_LAST_ID => 'value2',
        ];

        $httpHeader = new HttpHeader();
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

        $httpHeader = new HttpHeader();
        $simpleTracer = new SimpleTracer();
        $httpHeader->extract($simpleTracer, $headers);

        $this->assertFalse($simpleTracer->hasItem(SimpleTracer::MASTER_ID));
        $this->assertFalse($simpleTracer->hasItem(SimpleTracer::LAST_ID));
    }


}