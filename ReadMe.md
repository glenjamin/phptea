PHPTea
======

A simple, flexible test harness for specifying tests in a SpecBDD style.

Inspiration is taken from
[dspec](https://github.com/davedevelopment/dspec),
[Mocha](http://visionmedia.github.com/mocha/), and
[RSpec](http://rspec.info/)

Goals
-----

* PHP 5.3+ Support
* Simple expressive way to declare tests
* No magic in test execution
* Users are free to use their own assertion flavour
* Users are free to use their own mocking library

Usage
-----

``` php
<?php

describe("Calculator", function() {
    describe("->num", function() {
        it("should input number that can be read", function() {
            $c = new Calculator();
            $c->num(2);
            assertEqual(2, $c->read());
        });
    });
    describe("->add", function() {
        it("should add 2 and 2 and get 4", function() {
            $c = new Calculator();
            $c->num(2);
            $c->add();
            $c->num(2);
            assertEqual(4, $c->read());
        });
    });
});
```

Reducing duplication with beforeEach and helpers

``` php
<?php

describe("Calculator", function() {
    beforeEach(function($T) {
        $T->c = new Calculator();
        $T->assertReads = function($expected) use ($T) {
            assertEqual($expected, $T);
        };
    })
    describe("->num", function() {
        it("should input number that can be read", function($T) {
            $T->c->num(2);
            $T->assertReads(2);
        });
    });
    describe("->add", function() {
        it("should add 2 and 2 and get 4", function($T) {
            $T->c->num(2);
            $T->c->add();
            $T->c->num(2);
            $T->assertReads(4);
        });
    });
});
```

FAQs
----

**AHMAGAD there's global functions**

Yep, there's 4: `describe`, `it`, `beforeEach` and `afterEach`. If your project
also has global functions with any of these names, then I'm afraid we won't be
able to work together.

**Why don't you just use PHPSpec2**

PHPSpec2 is excellent, but it's a little bit too opinionated for our tastes.

**Why don't you just use PHPUnit**

PHPUnit, being of the xUnit family, isn't as expressive as a more recent BDD
style tools. It's been around for ages and we think its possible to leverage
newer PHP features to make something with a much nicer API.

Implementation Plan
-------------------

* Symfony2 Components
* First pass loads test files to build up test suite
* Second pass executes suite and records results
* Hook in formatters via event dispatcher
