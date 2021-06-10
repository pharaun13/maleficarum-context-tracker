<?php

namespace Miinto\ContextTracing\Worker;

use Maleficarum\Worker\Handler\Encapsulator\AbstractEncapsulator;

class ContextEncapsulator extends AbstractEncapsulator {
    public function beforeHandle(): bool {
        $messageContext = ContextAccess::extractContext($this->getHandler()->getCommand());
        $tracer = \Miinto\ContextTracing\ContextTracker::getTracer();
        $tracer->createSpanFromContext($messageContext);
        $tracer->addTag('HID', $this->getHandler()->getHandlerId());
        $tracer->addTag('WorkerId', $this->getHandler()->getWorkerId());

        return true;
    }

    public function afterHandle(bool $result): bool {
        \Miinto\ContextTracing\ContextTracker::clearContext();

        return true;
    }

}
