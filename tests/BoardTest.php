<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Gmk\Board;

class BoardTest extends TestCase
{
    public function testConstruct()
    {
        $range = 10;
        $board = new Board($range);

        $data = $board->getData();
        $this->assertSame($range ** 2, count($data));

        $values = array_count_values($data);
        $this->assertSame(1, count($values));
    }

    /**
     * @dataProvider constructExceptionProvider
     */
    public function testConstructException($expected_exception, $arg)
    {
        $this->expectException($expected_exception);

        $board = new Board($arg);
    }

    public function constructExceptionProvider(): array
    {
        return [
            [\InvalidArgumentException::class, -1],
        ];
    }

    public function testShow()
    {
        $board = new Board(5);

        ob_start();
        $board->show();
        $output_contents = ob_get_clean();

        $str_count = mb_substr_count($output_contents, '|');
        $line_feed_code_count = mb_substr_count($output_contents, "\n");
        $this->assertSame(30, $str_count);
        $this->assertSame(5, $line_feed_code_count);
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
            [10, 10, 9],
            [10, 9, 10],
            [1, 2, 2],
            [0, 0, 0]
        ];
    }
}
