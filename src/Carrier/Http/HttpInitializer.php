<?php


namespace Maleficarum\ContextTracing\Carrier\Http;


use Maleficarum\ContextTracing\ContextTracker;
use Maleficarum\ContextTracing\Identifiers\TrackingId;
use Maleficarum\ContextTracing\SimpleTracer;

class HttpInitializer
{
    /**
     * @param array $headers
     * @param string $serviceName
     */
    static public function initialize(array $headers, $serviceName)
    {
        $tracer = ContextTracker::getTracer();
        (new HttpHeader())->extract($tracer, $headers);
        $id = TrackingId::RID($serviceName);
        if (!$tracer->hasItem(SimpleTracer::MASTER_ID)) {
            $tracer->addItem(SimpleTracer::MASTER_ID, $id->generate());
        }
        $tracer->addItem(SimpleTracer::CURRENT_ID, $id->generate());
    }
}