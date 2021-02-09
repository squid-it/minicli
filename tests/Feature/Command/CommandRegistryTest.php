<?php

use Minicli\Command\CommandNamespace;
use Minicli\Exception\CommandNotFoundException;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

it('asserts Registry autoloads command namespaces', function () {
    $registry = getRegistry();
    $namespace = $registry->getNamespace("test");

    assertNotNull($namespace);
    assertTrue($namespace instanceof CommandNamespace);
});

it('asserts Registry returns null when a namespace is not found', function () {
    $registry = getRegistry();
    $namespace = $registry->getNamespace("dasdsad");

    assertNull($namespace);
});

it('asserts Registry returns correct controller from namespace when no subcommand is passed', function () {
    $registry = getRegistry();
    $controller = $registry->getCallableController("test");

    assertEquals('Assets\Command\Test\DefaultController', $controller);
});

it('asserts Registry returns correct controller from namespace when a subcommand is passed', function () {
    $registry = getRegistry();
    $controller = $registry->getCallableController("test", "help");

    assertEquals('Assets\Command\Test\HelpController', $controller);
});

it('asserts Registry returns null when a namespace controller is not found', function () {
    $registry = getRegistry();
    $controller = $registry->getCallableController("dasdsad");

    assertNull($controller);
});

it('asserts Registry returns correct callable', function () {
    $registry = getRegistry();
    $callable = $registry->getCallable("minicli-test");

    assertTrue(is_callable($callable));
});

it('asserts Registry throws CommandNotFoundException when a command is not found', function () {
    $registry = getRegistry();
    $callable = $registry->getCallable("dasdakjsdasd");
})->throws(CommandNotFoundException::class);

it('assets Registry returns full command list', function () {
    $registry = getRegistry();

    $command_list = $registry->getCommandMap();
    assertCount(2, $command_list);
    assertCount(5, $command_list['test']);
});
