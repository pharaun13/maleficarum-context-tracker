<?php


namespace Maleficarum\ContextTracing\Tests\Logger;


use Maleficarum\ContextTracing\Logger\Formatter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    public function testFormat()
    {
        $formatedMessage = Formatter::format('My log message', ['masterId' => '123', 'currentId' => '456']);

        $this->assertEquals('[masterId: 123] [currentId: 456] My log message', $formatedMessage);
    }
}