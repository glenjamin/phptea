<?php

namespace PHPTea\PHPTea;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Example
{
    protected $spec;

    protected $func;

    public function __construct($spec, $func)
    {
        $this->spec = $spec;
        $this->func = $func;
    }

    public function run(EventDispatcher $progress)
    {
        $progress->dispatch(
            Event::EXAMPLE_START,
            new Event\DescribedEvent($this->spec)
        );
        try {
            $func = $this->func;
            $func();
        } catch (\Exception $ex) {
            $progress->dispatch(
                Event::EXAMPLE_ENDED,
                new Event\ResultEvent($this->spec, false, $ex)
            );
            return 1;
        }
        $progress->dispatch(
            Event::EXAMPLE_ENDED,
            new Event\ResultEvent($this->spec, true)
        );
        return 0;
    }
}
