<?php

use Minicli\Command\CommandCall;
use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

it('asserts input arguments are loaded and properties are set', function () {
    $call = new CommandCall(["minicli", "help", "test"]);

    assertCount(3, $call->getRawArgs());
    assertEquals("help", $call->command);
    assertEquals("test", $call->subcommand);
});

it('asserts flags are correctly set', function () {
    $call = new CommandCall(["minicli", "help", "test", "--flag"]);

    assertTrue($call->hasFlag('--flag'));
    assertContains("--flag", $call->getFlags());
});

it('asserts params are correctly set', function () {
    $call = new CommandCall(["minicli", "help", "test", "name=test"]);

    assertTrue($call->hasParam('name'));
    assertEquals('test', $call->getParam('name'));
});
