<?php
namespace Gmk;

class Board
{
    private $data;

    public function __construct(int $n)
    {
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $this->data[$i][$j] = '';
            }
        }
    }

    public function show()
    {
        foreach ($this->data as $line) {
            echo "|";
            foreach ($line as $cell) {
                echo ($cell !== '') ? $cell : " ";
                echo "|";
            }
            echo PHP_EOL;
        }
    }
}
