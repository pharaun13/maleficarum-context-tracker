<?php


namespace Maleficarum\ContextTracing\Carrier\Amqp;


use Maleficarum\ContextTracing\Carrier\Http\HttpHeader;
use Maleficarum\ContextTracing\ContextTracker;
use Maleficarum\ContextTracing\Identifiers\TrackingId;
use Maleficarum\ContextTracing\SimpleTracer;

class AmqpInitializer
{
    /**
     * @param array $headers
     * @param string $serviceName
     */
    static public function initialize(array $headers, $serviceName)
    {
        $tracer = ContextTracker::getTracer();
        (new AmqpHeader())->extract($tracer, $headers);
        $id = TrackingId::RID($serviceName);
        if (!$tracer->hasItem(SimpleTracer::MASTER_ID)) {
            $tracer->addItem(SimpleTracer::MASTER_ID, $id->generate());
        }
        $tracer->addItem(SimpleTracer::CURRENT_ID, $id->generate());
        ContextTracker::init($tracer);
    }
}