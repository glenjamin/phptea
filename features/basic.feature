Feature: Basic Test running

As a: Developer
I want to: Specify behaviour of my code
So that: I know it meets requirements

Scenario: One passing example of one function
    Given "basic-spec.php" contains:
    """
    <?php
    function add($a, $b) {
        return $a + $b;
    }
    function assertEquals($a, $b) {
        if ($a === $b) return;
        throw new UnexpectedValueException("Expected $a to equal $b");
    }

    describe("add()", function() {
        it("should produce 4 from 2 and 2", function() {
            assertEquals(add(2, 2), 4);
        });
    });
    """
    When I run phptea with "basic-spec.php"
    Then it should pass

Scenario: One failing example of one function
    Given "basic-spec.php" contains:
    """
    <?php
    function add($a, $b) {
        return $a - $b;
    }
    function assertEquals($a, $b) {
        if ($a === $b) return;
        throw new UnexpectedValueException("Expected $a to equal $b");
    }

    describe("add()", function() {
        it("should produce 4 from 2 and 2", function() {
            assertEquals(add(2, 2), 4);
        });
    });
    """
    When I run phptea with "basic-spec.php"
    Then it should fail
