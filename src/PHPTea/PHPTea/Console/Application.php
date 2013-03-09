<?php
namespace PHPTea\PHPTea\Console;

use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputInterface;

use PHPTea\PHPTea\Core;

class Application extends Console\Application {

    public function __construct() {
        parent::__construct('PHPTea', Core::VERSION);

        // Remove the built-in "command" argument, since we override
        $this->getDefinition()->setArguments();
    }

    public function getCommandName(InputInterface $input) {
        return 'phptea';
    }

    public function getDefaultCommands() {
        return array(new Console\Command\HelpCommand, new RunCommand);
    }
}
