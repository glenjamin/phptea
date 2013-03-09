<?php

namespace PHPTea\PHPTea;

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

    public function run()
    {
        $result = 0;
        foreach($this->children as $child) {
            $result |= $child->run();
        }
        return $result;
    }

}
