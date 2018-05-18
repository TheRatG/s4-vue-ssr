<?php


namespace App\Service;


use App\VueState\VueStateInterface;

class VueStateCollection
{
    protected $handlers = [];

    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @return array|iterable|VueStateInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }
}