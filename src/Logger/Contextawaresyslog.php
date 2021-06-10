<?php

namespace Maleficarum\Worker\Logger\Facility;

use Maleficarum\Worker\Logger\Facility\Syslog;
use Miinto\ContextTracing\ContextTracker;

class Contextawaresyslog extends Syslog
{
    public function write($data, string $level): \Maleficarum\Worker\Logger\Facility\Facility
    {
        $contextString = substr(json_encode(ContextTracker::getTracer()->flatten()), 0, 200);
        $enrichedData = null;
        if (is_array($data)) {
            $enrichedData = $data;
            $enrichedData['context'] = $contextString;
        } else if (is_string($data)) {
            $enrichedData = 'Context: ' . $contextString . ' Log: ' . $data;
        }
        parent::write($enrichedData, $level);

        return $this;
    }

}
