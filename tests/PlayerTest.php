<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Gmk\Player;

class PlayerTest extends TestCase
{
    /**
     * @dataProvider getNameProvider
     */
    public function testGetName($name)
    {
        $player = new Player($name, "x");

        $expected = trim($name);
        $this->assertEquals($expected, $player->getName());
    }

    public function getNameProvider(): array
    {
        return [
            ["山田 鈴木"], ["aaaaaaaaaa"], ["a"], [" uあああ"], ["ああああ u "]
        ];
    }

    /**
     * @dataProvider constructorExceptionProvider
     */
    public function testConstructorException($expected_exception, $name, $stone)
    {
        $this->expectException($expected_exception);

        $p = new Player($name, $stone);
    }

    /**
     * @dataProvider getStoneProvider
     */
    public function testGetStone($stone)
    {
        $player = new Player('player', $stone);

        $expected = trim($stone);
        $this->assertEquals($expected, $player->getStone());
    }

    public function constructorExceptionProvider(): array
    {
        return [
            [\InvalidArgumentException::class, "", "○"],
            [\InvalidArgumentException::class, "12345678901", "○"],
            [\InvalidArgumentException::class, "name", ""],
            [\InvalidArgumentException::class, "name", "12"],
            [\InvalidArgumentException::class, "name", "石石"],
        ];
    }

    public function getStoneProvider(): array
    {
        return [
            ["●"], ["○"], ["a"], ["1"], ["・"], ["石"], [" x"], ["x "]
        ];
    }
}
