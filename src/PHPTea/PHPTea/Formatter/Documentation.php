<?php

namespace PHPTea\PHPTea\Formatter;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use PHPTea\PHPTea\Event;

class Documentation implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            Event::GROUP_START => array('onGroupStart', 0),
            Event::GROUP_ENDED => array('onGroupEnded', 0),
            Event::EXAMPLE_ENDED => array('onExampleEnded', 0),
        );
    }

    public function __construct()
    {
        $this->indent = 0;
    }

    protected function println($msg)
    {
        echo str_repeat(' ', $this->indent) . $msg . "\n";
    }

    public function onGroupStart(Event\DescribedEvent $event)
    {
        $this->println($event->getSpec());
        $this->indent += 2;
    }

    public function onGroupEnded()
    {
        $this->indent -= 2;
    }

    public function onExampleEnded(Event\ResultEvent $event)
    {
        if ($event->didPass()) {
            $this->println('✓ ' . $event->getSpec());
        } else {
            $this->println('✗ ' . $event->getSpec());
        }
    }
}
