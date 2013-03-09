<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once 'PHPUnit/Framework/Assert/Functions.php';

define('BEHAT_ERROR_REPORTING', E_ALL);

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     *
     * @param array $parameters context parameters from behat.yml
     */
    public function __construct(array $parameters)
    {
        $this->debug = false;
        $this->dir = tempnam(sys_get_temp_dir(), 'phptea');
        // Tempnam creates a file, turn it into a directory
        unlink($this->dir);
        mkdir($this->dir);
        if (!is_dir($this->dir) || !is_writeable($this->dir)) {
            throw new RuntimeException('Could not create writable temp dir');
        }
    }

    public function __destruct()
    {
        // Lazy way to clean up temp dir
        exec('rm -rf ' . $this->dir);
    }

    /**
     * @BeforeScenario @debug
     */
    public function setDebug()
    {
        $this->debug = true;
    }

    /**
     * @Given /^"([^"]*)" contains:$/
     */
    public function contains($filename, PyStringNode $string)
    {
        $a = array();
        file_put_contents($this->buildFilename($filename), $string);
    }

    /**
     * @When /^I run phptea with "([^"]*)"$/
     */
    public function iRunPhpteaWith($args)
    {
        $cmd = $this->getExecutable() . ' ' . $args;
        $proc = proc_open(
            $cmd,
            array(
                0 => array('pipe', 'r'),
                1 => array('pipe', 'w'),
                2 => array('pipe', 'w'),
            ),
            $pipes,
            $this->dir
        );
        if (!is_resource($proc)) {
            throw new RuntimeException('Failed to run ' . $cmd);
        }
        fclose($pipes[0]);

        $this->stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $this->debug && print($this->stdout);
        $this->stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $this->retval = proc_close($proc);
    }

    /**
     * @Then /^it should pass$/
     */
    public function itShouldPass()
    {
        assertSame(0, $this->retval, "Process returned non-zero exit code");
    }

    /**
     * @Then /^it should fail$/
     */
    public function itShouldFail()
    {
        assertNotSame(0, $this->retval, "Process returned zero exit code");
    }

    /**
     * @Then /^the output should be:$/
     */
    public function theOutputShouldBe(PyStringNode $string)
    {
        assertEquals((string) $string, $this->stdout);
    }

    /**
     * Get location of phptea binary
     */
    protected function getExecutable()
    {
        return realpath(__DIR__ . '/../../bin/phptea');
    }

    /**
     * Generate a filename inside the temp directory
     */
    protected function buildFilename($basename)
    {
        return $this->dir . '/' . $basename;
    }
}
