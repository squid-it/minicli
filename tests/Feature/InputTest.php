<?php

use Minicli\Input;
use function PHPUnit\Framework\assertEquals;

it('asserts that Input sets a default prompt', function () {
    $input = new Input();

    assertEquals('minicli$> ', $input->getPrompt());
});
