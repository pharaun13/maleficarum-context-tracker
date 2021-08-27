<?php


namespace Maleficarum\ContextTracing\Initializer;

use Maleficarum\ContextTracing\Carrier\Http\HttpHeader;
use Maleficarum\ContextTracing\Carrier\Http\HttpHeaderProvider;
use Maleficarum\ContextTracing\ContextTracker;
use Maleficarum\ContextTracing\SimpleTracer;
use Maleficarum\ContextTracing\Identifiers\TrackingId;

class HttpInitializer
{
    static public function initialize(array $opts = [])
    {
        $tracer = new SimpleTracer();
        /** @var HttpHeaderProvider $provider */
        $provider = $opts['http_header_provider'];
        (new HttpHeader())->extract($tracer, $provider->getHeaders());
        $id = TrackingId::RID($opts['context.service_name']);
        if (!$tracer->hasItem(SimpleTracer::MASTER_ID)) {
            $tracer->addItem(SimpleTracer::MASTER_ID, $id->generate());
        }
        $tracer->addItem(SimpleTracer::CURRENT_ID, $id->generate());
        ContextTracker::init($tracer);
    }
}