<?php


namespace Maleficarum\ContextTracing\Carrier\Generic;


use Maleficarum\ContextTracing\ContextTracker;
use Maleficarum\ContextTracing\Identifiers\TrackingId;
use Maleficarum\ContextTracing\SimpleTracer;

class Initializer
{
    /**
     * @param array $headers
     * @param string $serviceName
     */
    static public function initialize(array $headers, $serviceName)
    {
        $tracer = new SimpleTracer();
        (new Header())->extract($tracer, $headers);
        if (!is_string($serviceName)) {
            $serviceName = 'service';
        }
        $id = TrackingId::RID($serviceName);
        if (!$tracer->hasItem(SimpleTracer::MASTER_ID)) {
            $tracer->addItem(SimpleTracer::MASTER_ID, $id->generate());
        }
        $tracer->addItem(SimpleTracer::CURRENT_ID, $id->generate());
        ContextTracker::init($tracer);
    }
}