<?php
namespace Gmk;

class Player
{
    const NAME_MAX_LENGTH = 10;
    const STONE_MAX_LENGTH = 1;

    /** @var string */
    private $name;

    /** @var string */
    private $stone;

    public function __construct(string $name, string $stone)
    {
        $this->name  = trim($name);
        $this->stone = trim($stone);

        $this->validate();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStone()
    {
        return $this->stone;
    }

    private function validate()
    {
        if ($this->name === '' || mb_strlen($this->name) > self::NAME_MAX_LENGTH) {
            throw new \InvalidArgumentException();
        }

        if ($this->stone === '' || mb_strlen($this->stone) > self::STONE_MAX_LENGTH) {
            throw new \InvalidArgumentException();
        }
    }
}
