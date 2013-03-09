<?php

namespace PHPTea\PHPTea;

class ExampleGroup extends ExampleCollection
{
    protected $spec;

    protected $children;

    public function __construct($spec)
    {
        $this->spec = $spec;
        parent::__construct();
    }

}
