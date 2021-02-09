<?php
declare(strict_types=1);

namespace Assets\RandomClass;

class Reply
{
    protected $say;

    public function __construct(Say $say)
    {
        $this->say = $say;
    }

    public function myName($name): string
    {
        return $this->say->myName($name);
    }
}
