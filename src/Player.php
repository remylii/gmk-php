<?php
namespace Gmk;

class Player
{
    /**
     * @var string
     */
    private $stone;

    public function __construct(string $stone)
    {
        $this->stone = $stone;
    }

    public function myStone(): string
    {
        return $this->stone;
    }
}
