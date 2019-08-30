<?php
namespace Tests;

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
}
