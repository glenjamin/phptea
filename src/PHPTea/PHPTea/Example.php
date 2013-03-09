<?php

namespace PHPTea\PHPTea;

class Example
{
    protected $spec;

    protected $func;

    public function __construct($spec, $func)
    {
        $this->spec = $spec;
        $this->func = $func;
    }

    public function run()
    {
        try {
            $func = $this->func;
            $func();
        } catch (\Exception $ex) {
            return 1;
        }
        return 0;
    }
}
