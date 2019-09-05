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

    public function testAnnounce()
    {
        $expect = 'アメンボ赤いなabcde12345';
        ob_start();
        $this->ruler->announce('アメンボ赤いなabcde12345');
        $output_contents = ob_get_clean();

        $this->assertSame($expect, $output_contents);
    }

    /**
     * @dataProvider parseArgsXYProvider
     */
    public function testParseArgsXY($expected_x, $expected_y, $arg)
    {
        list($x, $y) = $this->ruler->parseArgsXY($arg);

        $this->assertSame($expected_x, $x);
        $this->assertSame($expected_y, $y);
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
        $this->assertSame($expected, $res);
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
            "右斜め" => [
                true, 10, [
                    [5, 5],
                    [6, 6],
                    [7, 7],
                    [8, 8],
                    [9, 9],
                ]
            ],
            "左斜め" => [
                true, 10, [
                    [0, 4],
                    [1, 3],
                    [2, 2],
                    [3, 1],
                    [4, 0],
                ]
            ],
            "横 まだ勝敗つかない" => [
                false, 10, [
                    [9, 0],
                    [9, 1],
                    [9, 2],
                    [9, 3],
                ]
            ],
            "縦 まだ勝敗つかない" => [
                false, 10, [
                    [6, 9],
                    [7, 9],
                    [8, 9],
                    [9, 9],
                ]
            ],
            "右斜め まだ勝敗つかない" => [
                false, 10, [
                    [6, 6],
                    [7, 7],
                    [8, 8],
                    [9, 9],
                ]
            ],
            "左斜め まだ勝敗つかない" => [
                false, 10, [
                    [6, 3],
                    [7, 2],
                    [8, 1],
                    [9, 0],
                ]
            ],
        ];
    }
}
