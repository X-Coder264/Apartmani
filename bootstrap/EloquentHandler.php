<?php

namespace Bootstrap;

use Monolog\Handler\AbstractProcessingHandler;

class EloquentHandler extends AbstractProcessingHandler {
    protected function write(array $record) {
        \App\MongoLogError::create([
            'env'     => $record['channel'],
            'formatted' => $record['formatted'],
            'level'   => $record['level_name'],
            'context' => $record['context'],
            'extra'   => $record['extra']
        ]);
    }
}