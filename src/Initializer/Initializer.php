<?php


namespace Maleficarum\ContextTracing\Initializer;


use Maleficarum\ContextTracing\Carrier\Http\AmqpHeader;
use Maleficarum\ContextTracing\ContextTracker;
use Maleficarum\ContextTracing\SimpleTracer;
use Maleficarum\ContextTracing\Identifiers\TrackingId;

class Initializer
{
    public function initialize(array $opts = [])
    {
        $tracer = new SimpleTracer();
        (new AmqpHeader())->extract($tracer, $this->getAllHeaders());
        $id = TrackingId::RID($opts['']);
        if (!$tracer->hasItem(SimpleTracer::MASTER_ID)) {
            $tracer->addItem(SimpleTracer::MASTER_ID, $id->generate());
        }
        $tracer->addItem(SimpleTracer::CURRENT_ID, $id->generate());
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