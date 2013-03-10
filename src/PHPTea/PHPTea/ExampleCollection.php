<?php

namespace PHPTea\PHPTea;

use Symfony\Component\EventDispatcher\EventDispatcher;

class ExampleCollection
{
    protected $children;

    public function __construct()
    {
        $this->children = array();
    }

    public function add($child)
    {
        $this->children[] = $child;
    }

    public function run(EventDispatcher $progress)
    {
        $result = 0;
        foreach($this->children as $child) {
            $result |= $child->run($progress);
        }
        return $result;
    }

}
