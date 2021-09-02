<?php


namespace Maleficarum\ContextTracing\Initializer;

class MaleficarumHttpInitializer
{
    static public function initialize(array $opts = [])
    {
        try {
            $headers = (new \Phalcon\Http\Request())->getHeaders();
        } catch (\Exception $exception) {
            $headers = [];
        }
        if (!is_array($headers)) {
            $headers = [];
        }
        \Maleficarum\ContextTracing\Carrier\Generic\Initializer::initialize(
            $headers,
            array_key_exists('prefix', $opts) ? $opts['prefix'] : 'service'
        );
    }
}