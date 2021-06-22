<?php


namespace Maleficarum\ContextTracing\Plugin;


use Maleficarum\ContextTracing\ContextTracker;

class MaleficarumMonologLogger
{
    public function addProcessor($logger)
    {
        $logger->pushProcessor(function (array $record) {
            $record['context'] = array_merge(
                $record['context'],
                ContextTracker::getTracer()->flatten()
            );

            return $record;
        });
    }
}