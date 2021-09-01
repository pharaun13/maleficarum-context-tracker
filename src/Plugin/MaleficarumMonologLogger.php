<?php


namespace Maleficarum\ContextTracing\Plugin;


use Maleficarum\ContextTracing\ContextTracker;
use Maleficarum\ContextTracing\Logger\Formatter;

class MaleficarumMonologLogger
{
    public static function addProcessor($logger)
    {
        $logger->pushProcessor(
            function (array $record) {
                try {
                    $flatContext = ContextTracker::getTracer()->flatten();

                    $record['message'] = Formatter::format($record['message'], $flatContext);
                } catch (\Exception $exception) {
                }

                return $record;
            }
        );
    }
}