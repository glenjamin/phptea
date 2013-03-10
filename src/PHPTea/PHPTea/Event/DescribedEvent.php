<?php

namespace PHPTea\PHPTea\Event;

use Symfony\Component\EventDispatcher\Event;

class DescribedEvent extends Event
{
    /**
     * @var string specification string
     */
    protected $spec;

    public function __construct($spec)
    {
        $this->spec = $spec;
    }

    /**
     * @return string specification string
     */
    public function getSpec()
    {
        return $this->spec;
    }
}
