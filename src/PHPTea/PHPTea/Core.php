<?php

namespace PHPTea\PHPTea;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Core extends ExampleCollection
{
    const VERSION = '0.1.0';

    protected $stack;

    /**
     * @var \PHPTea\PHPTea\Core
     */
    protected static $runner;

    public static function describe($spec, $func)
    {
        $group = new ExampleGroup($spec);
        static::$runner->append($group);
        static::$runner->push($group);
        $func();
        static::$runner->pop();
    }

    public static function it($spec, $func)
    {
        $example = new Example($spec, $func);
        static::$runner->append($example);
    }

    public static function newRunner()
    {
        return new static();
    }

    public static function useRunner(Core $runner)
    {
        if (!function_exists('describe')) {
            require __DIR__ . '/functions.php';
        }
        static::$runner = $runner;
    }

    public function __construct()
    {
        $this->children = array();
        $this->stack = array($this);
    }

    public function loadFiles(array $files)
    {
        static::useRunner($this);
        foreach($files as $file) {
            include $file;
        }
    }

    public function run(EventDispatcher $progess)
    {
        $progess->dispatch(Event::SUITE_START);
        $result = parent::run($progess);
        $progess->dispatch(Event::SUITE_ENDED);
        return $result;
    }

    protected function append($child)
    {
        $top = end($this->stack);
        $top->add($child);
    }

    protected function push(ExampleGroup $group)
    {
        $this->stack[] = $group;
    }

    protected function pop()
    {
        array_pop($this->stack);
    }

}
