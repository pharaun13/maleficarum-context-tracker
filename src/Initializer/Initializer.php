<?php


namespace Maleficarum\ContextTracing\Initializer;


use Maleficarum\ContextTracing\Carrier\Http\HttpHeader;
use Maleficarum\ContextTracing\ContextTracker;
use Maleficarum\ContextTracing\SimpleTracer;

class Initializer
{
    public function initialize(array $opts = [])
    {
        $tracer = new SimpleTracer();
        (new HttpHeader())->extract($tracer, $this->getAllHeaders());
        ContextTracker::init($tracer);
    }

    private function getAllHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}