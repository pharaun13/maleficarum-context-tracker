<?php


namespace Maleficarum\ContextTracing\Tests\Plugin;


use Maleficarum\ContextTracing\Plugin\MaleficarumMonologLogger;
use PHPUnit\Framework\TestCase;

class MaleficarumMonologLoggerTest extends TestCase
{
    public function testPlugin()
    {
        MaleficarumMonologLogger::addProcessor(new class {
            public function pushProcessor($callable)
            {

            }
        });
    }
}