<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Gmk\GameManager;

class GameManagerTest extends TestCase
{
    public function testConstruct()
    {
        $game = new GameManager();
        $this->assertTrue(true);
    }
}
