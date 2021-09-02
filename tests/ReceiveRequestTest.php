<?php


namespace Maleficarum\ContextTracing\Tests;


use Maleficarum\ContextTracing\Carrier\Generic\Header;
use Maleficarum\ContextTracing\SimpleTracer;
use PHPUnit\Framework\TestCase;

class ReceiveRequestTest extends TestCase
{
    public function testExtractItems()
    {
        $headers = [
           Header::X_MIINTO_CONTEXT_MASTER_ID => 'value1',
            Header::X_MIINTO_CONTEXT_LAST_ID => 'value2',
        ];

        $httpHeader = new Header();
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

        $httpHeader = new Header();
        $simpleTracer = new SimpleTracer();
        $httpHeader->extract($simpleTracer, $headers);

        $this->assertFalse($simpleTracer->hasItem(SimpleTracer::MASTER_ID));
        $this->assertFalse($simpleTracer->hasItem(SimpleTracer::LAST_ID));
    }


}