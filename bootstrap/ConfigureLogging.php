<?php

namespace Bootstrap;

use Bootstrap\EloquentHandler;
use Bootstrap\RequestProcessor;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseConfigureLogging;

class ConfigureLogging extends BaseConfigureLogging {
    public function bootstrap(Application $app) {
        $log = $this->registerLogger($app)->getMonolog();

        $log->pushHandler(new EloquentHandler());
        $log->pushProcessor(new RequestProcessor());
    }
}