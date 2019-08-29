<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Gmk\GameManager;

class GameManagerTest extends TestCase
{
    public function testStart()
    {
        ob_start();

        $gm = new GameManager();
        $gm->start();

        $output_contents = ob_get_clean();

        $this->assertEquals("GAME START!\n", $output_contents);
    }
}
