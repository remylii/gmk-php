<?php
namespace Gmk;

class Board
{
    const INIT_CELL = '';

    private $data;

    public function __construct(int $n)
    {
        try {
            if ($n < 0) {
                throw new \InvalidArgumentException();
            }

            $line = array_fill(0, $n, self::INIT_CELL);
            $this->data = array_fill(0, $n, $line);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function show()
    {
        foreach ($this->data as $line) {
            echo "|";
            foreach ($line as $cell) {
                echo ($cell !== self::INIT_CELL) ? $cell : " ";
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

        if ($this->data[$x][$y] !== self::INIT_CELL) {
            throw new \LogicException('すでに置いてある');
        }

        $this->data[$x][$y] = $p;

        return true;
    }
}
