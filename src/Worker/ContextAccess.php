<?php

namespace Miinto\ContextTracing\Worker;

class ContextAccess {
    public static function extractContext(\Maleficarum\Command\AbstractCommand $abstractCommand) {
        $meta = $abstractCommand->getCommandMetaData();
        return $meta['context'] ?? [];
    }
}
