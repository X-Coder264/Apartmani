<?php

namespace Bootstrap;


class RequestProcessor {
    public function __invoke(array $record) {
        $request = request();

        $record['extra']['serve'] = $request->server('SERVER_ADDR');
        $record['extra']['host'] = $request->getHost();
        $record['extra']['uri'] = $request->getPathInfo();
        $record['extra']['request'] = $request->all();

        return $record;
    }
}