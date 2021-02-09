<?php

use Minicli\Command\CommandNamespace;
use function PHPUnit\Framework\assertContainsOnly;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNotEmpty;

function getCommandNamespace()
{
    return new CommandNamespace("Test");
}

it('asserts that a name is set as expected', function () {
    $namespace = getCommandNamespace();

    assertEquals("Test", $namespace->getName());
});

it('asserts that controllers are loaded successfully', function () {
    $namespace = getCommandNamespace();
    $controllers = $namespace->loadControllers(getCommandsPath());

    assertIsArray($controllers);
    assertNotEmpty($controllers);
    assertContainsOnly('string', $controllers);
});

it('asserts that no controllers are returned if the namespace is empty', function () {
    $namespace = new CommandNamespace("Empty");
    $controllers = $namespace->loadControllers(getCommandsPath());

    assertCount(0, $controllers);
});
