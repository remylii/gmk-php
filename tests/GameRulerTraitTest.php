<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Gmk\Board;

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


    /**
     * @dataProvider judgementProvider
     */
    public function testJudgementLine($expected, $max_cell, $params)
    {
        $stone = 'x';
        $board = new Board($max_cell);
        foreach ($params as $val) {
            $board->put($stone, $val[0], $val[1]);
        }

        $res = $this->ruler->judgement($stone, $board->getData());
        $this->assertEquals($expected, $res);
    }

    public function judgementProvider(): array
    {
        return [
            "横勝ち" => [
                true, 10, [
                    [1, 1],
                    [1, 2],
                    [1, 3],
                    [1, 4],
                    [1, 5],
                ]
            ],
            "縦勝ち" => [
                true, 10, [
                    [1, 0],
                    [2, 0],
                    [3, 0],
                    [4, 0],
                    [5, 0],
                ]
            ],
            "まだ勝敗つかない" => [
                false, 10, [
                    [9, 0],
                    [9, 1],
                    [9, 2],
                    [9, 3],
                ]
            ],
        ];
    }
}
