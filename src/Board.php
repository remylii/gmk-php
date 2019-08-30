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

    public function put(string $p, int $x, int $y): bool
    {
        if (!isset($this->data[$x][$y])) {
            throw new \InvalidArgumentException('座標軸が存在しない');
        }

        if ($this->data[$x][$y] !== '') {
            throw new \LogicException('すでに置いてある');
        }

        $this->data[$x][$y] = $p;

        return true;
    }
}
