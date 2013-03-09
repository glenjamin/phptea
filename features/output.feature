Feature: Specification style output

As a: Developer
I want to: Produce a readable specification from my tests
So that: I have my tests describing behaviour

Scenario: Passing and Failing tests
    Given "basic-spec.php" contains:
    """
    <?php
    function add($a, $b) {
        return (int) $a + $b;
    }
    function assertEquals($a, $b) {
        if ($a === $b) return;
        throw new UnexpectedValueException("Expected $a to equal $b");
    }

    describe("add()", function() {
        it("should get 2 from 1 and 1", function() {
            assertEquals(add(1, 1), 2);
        });
        describe("negative numbers", function() {
            it("should get 4 from -1 and 5", function() {
                assertEquals(add(-1, 5), 4);
            });
            it("should get -9 from -4 and -5", function() {
                assertEquals(add(-4, -5), -9);
            });
        });
        describe("floating point", function() {
            it("should get 2.5 from 1.1 and 1.4", function() {
                assertEquals(add(1.1, 1.4), 2.5);
            });
        });
    });
    """
    When I run phptea with "basic-spec.php"
    Then it should fail
    And the output should be:
    """
    add()
      ✓ should get 2 from 1 and 1
      negative numbers
        ✓ should get 4 from -1 and 5
        ✓ should get -9 from -4 and -5
      floating point
        ✗ should get 2.5 from 1.1 and 1.4
    """

