<?php


namespace Maleficarum\ContextTracing\Initializer;

use Maleficarum\ContextTracing\Carrier\Http\HttpHeader;
use Maleficarum\ContextTracing\ContextTracker;
use Maleficarum\ContextTracing\SimpleTracer;
use Maleficarum\ContextTracing\Identifiers\TrackingId;

class HttpInitializer
{
    static public function initialize(array $opts = [])
    {
        $tracer = new SimpleTracer();
        (new HttpHeader())->extract($tracer, self::getAllHeaders());
        $id = TrackingId::RID($opts['service_name']);
        if (!$tracer->hasItem(SimpleTracer::MASTER_ID)) {
            $tracer->addItem(SimpleTracer::MASTER_ID, $id->generate());
        }
        $tracer->addItem(SimpleTracer::CURRENT_ID, $id->generate());
        ContextTracker::init($tracer);
    }

    static private function getAllHeaders()
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