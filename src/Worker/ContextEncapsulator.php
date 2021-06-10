<?php

namespace Miinto\ContextTracing\Worker;

use Maleficarum\Worker\Handler\Encapsulator\AbstractEncapsulator;

class ContextEncapsulator extends AbstractEncapsulator {
    public function beforeHandle(): bool {
        $messageContext = ContextAccess::extractContext($this->getHandler()->getCommand());
        $tracer = \Miinto\ContextTracing\ContextTracker::getTracer();
        $tracer->createSpanFromContext($messageContext);

        return true;
    }

    public function afterHandle(bool $result): bool {
        \Miinto\ContextTracing\ContextTracker::clearContext();

        return true;
    }

}
