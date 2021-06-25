<?php


namespace Maleficarum\ContextTracing\Carrier\Http;


use Maleficarum\ContextTracing\SimpleTracer;
use Maleficarum\ContextTracing\TracerInterface;

class HttpHeader
{
    const X_MIINTO_CONTEXT_MASTER_ID = 'X-Miinto-Context-Masterid';
    const X_MIINTO_CONTEXT_LAST_ID = 'X-Miinto-Context-Lastid';

    /**
     * @param TracerInterface $tracer
     * @param array $outgoingHeaders
     * @return array $headers
     */
    public function inject(TracerInterface $tracer, array $outgoingHeaders)
    {
        $masterId = $tracer->getItem(SimpleTracer::MASTER_ID);
        $currentId = $tracer->getItem(SimpleTracer::CURRENT_ID);

        if ($masterId) {
            $outgoingHeaders[self::X_MIINTO_CONTEXT_MASTER_ID] = $masterId;
        }
        if ($currentId) {
            $outgoingHeaders[self::X_MIINTO_CONTEXT_LAST_ID] = $currentId;
        }

        return $outgoingHeaders;
    }

    public function extract(TracerInterface $tracer, array $incomingHeaders)
    {
        if(array_key_exists(self::X_MIINTO_CONTEXT_MASTER_ID, $incomingHeaders)) {
            $tracer->addItem(SimpleTracer::MASTER_ID, $incomingHeaders[self::X_MIINTO_CONTEXT_MASTER_ID]);
        }
        if(array_key_exists(self::X_MIINTO_CONTEXT_LAST_ID, $incomingHeaders)) {
            $tracer->addItem(SimpleTracer::LAST_ID, $incomingHeaders[self::X_MIINTO_CONTEXT_LAST_ID]);
        }
    }
}