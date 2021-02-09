<?php

namespace Assets\Command\Test;

use Assets\RandomClass\Reply;
use Minicli\Command\CommandController;

class DiController extends CommandController
{
    /**
     * @var Reply
     */
    private $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function handle()
    {
        $this->getPrinter()->rawOutput($this->reply->myName('my name is DI'));
    }
}
