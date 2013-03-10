<?php

namespace PHPTea\PHPTea\Event;

class ResultEvent extends DescribedEvent
{
    /**
     * @var boolean
     */
    protected $result;

    /**
     * @var Exception
     */
    protected $exception;

    public function __construct($spec, $result, $exception = null)
    {
        parent::__construct($spec);
        $this->result = $result;
        $this->exception = $exception;
    }

    /**
     * @return boolean was the result a pass?
     */
    public function didPass()
    {
        return $this->result;
    }

    /**
     * @return Exception null if not a failure
     */
    public function getException()
    {
        return $this->exception;
    }
}
