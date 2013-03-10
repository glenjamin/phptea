<?php

namespace PHPTea\PHPTea;

class Event
{
    const SUITE_START   = 'phptea.suite-start';
    const SUITE_ENDED   = 'phptea.suite-ended';
    const GROUP_START   = 'phptea.group-start';
    const GROUP_ENDED   = 'phptea.group-ended';
    const EXAMPLE_START = 'phptea.example-start';
    const EXAMPLE_ENDED = 'phptea.example-ended';
}
