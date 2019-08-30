<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Gmk\Board;

class BoardTest extends TestCase
{
    public function testShow()
    {
        $board = new Board(5);

        ob_start();
        $board->show();
        $output_contents = ob_get_clean();

        $str_count = mb_substr_count($output_contents, '|');
        $line_feed_code_count = mb_substr_count($output_contents, "\n");
        $this->assertEquals(30, $str_count);
        $this->assertEquals(5, $line_feed_code_count);
    }

    public function testPut()
    {
        $limit = 25;
        $board = new Board($limit);
        for ($i = 0; $i < $limit; $i++) {
            for ($j = 0; $j < $limit; $j++) {
                $this->assertTrue($board->put('x', $i, $j));
            }
        }
    }

    public function testPutDuplicate()
    {
        $this->expectException(\LogicException::class);
        $board = new Board(2);
        $board->put('x', 0, 0);
        $board->put('y', 0, 0);
    }

    /**
     *
     * @dataProvider putOutRangeProvider
     */
    public function testPutOutRange($range, $x, $y)
    {
        $this->expectException(\InvalidArgumentException::class);
        $board = new Board($range);
        $board->put('○', $x, $y);
    }

    public function putOutRangeProvider(): array
    {
        return [
            [1, 2, 1],
            [1, 1, 2],
            [1, 2, 2],
            [0, 0, 0]
        ];
    }
}
