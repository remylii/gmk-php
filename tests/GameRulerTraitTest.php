<?php

namespace Test;

use PHPUnit\Framework\TestCase;

class GameRulerTraitTest extends TestCase
{
    protected $ruler;

    protected function setUp(): void
    {
        $this->ruler = new class {
            use \Gmk\Libs\GameRulerTrait;
        };
    }

    /**
     * @dataProvider parseArgsXYProvider
     */
    public function testParseArgsXY($expected_x, $expected_y, $arg)
    {
        list($x, $y) = $this->ruler->parseArgsXY($arg);

        $this->assertEquals($expected_x, $x);
        $this->assertEquals($expected_y, $y);
    }

    public function parseArgsXYProvider(): array
    {
        return [
            [0, 0, '0,0'],
            [90, 0, '90,0'],
            [0, 50, '0,50'],
            [100, 9, '100,9']
        ];
    }

    /**
     * @dataProvider exceptionParseArgsXYProvider
     */
    public function testExceptionParseArgsXY($expected_exception, $arg)
    {
        $this->expectException($expected_exception);

        $this->ruler->parseArgsXY($arg);
    }

    public function exceptionParseArgsXYProvider(): array
    {
        return [
            [\InvalidArgumentException::class, "0, 0"],
            [\InvalidArgumentException::class, " 1,1"],
            [\InvalidArgumentException::class, " 1,1 "],
            [\InvalidArgumentException::class, "1:1"],
        ];
    }



    public function judgement()
    {

    }
}
