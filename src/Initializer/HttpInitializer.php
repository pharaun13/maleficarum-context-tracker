<?php


namespace Maleficarum\ContextTracing\Initializer;

class HttpInitializer
{
    static public function initialize(array $opts = [])
    {
        $app = $opts['app'];
        \Maleficarum\ContextTracing\Carrier\Http\HttpInitializer::initialize(
            $app->request->getHeaders(),
            array_key_exists('prefix', $opts) ? $opts['prefix'] : 'service'
        );
    }
}