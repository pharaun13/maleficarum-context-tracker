<?php


namespace Maleficarum\ContextTracing\Initializer;

class MaleficarumHttpInitializer
{
    static public function initialize(array $opts = [])
    {
        \Maleficarum\ContextTracing\Carrier\Http\HttpInitializer::initialize(
            (new \Phalcon\Http\Request())->getHeaders(),
            array_key_exists('prefix', $opts) ? $opts['prefix'] : 'service'
        );
    }
}