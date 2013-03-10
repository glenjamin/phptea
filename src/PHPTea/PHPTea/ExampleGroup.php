<?php

namespace PHPTea\PHPTea;

use Symfony\Component\EventDispatcher\EventDispatcher;

class ExampleGroup extends ExampleCollection
{
    protected $spec;

    protected $children;

    public function __construct($spec)
    {
        $this->spec = $spec;
        parent::__construct();
    }

    public function run(EventDispatcher $progess)
    {
        $progess->dispatch(
            Event::GROUP_START,
            new Event\DescribedEvent($this->spec)
        );
        $result = parent::run($progess);
        $progess->dispatch(
            Event::GROUP_ENDED,
            new Event\ResultEvent($this->spec, !!$result)
        );
        return $result;
    }

}
