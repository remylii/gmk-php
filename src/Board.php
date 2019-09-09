<?php
namespace Gmk;

class Board
{
    const INIT_CELL = '';

    /** @var int */
    private $line_length;

    /** @var array */
    private $data;

    public function __construct(int $n)
    {
        try {
            if ($n < 0) {
                throw new \InvalidArgumentException();
            }

            $this->line_length = $n;
            $this->data = array_fill(0, $n ** 2, self::INIT_CELL);
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
        $arr = array_chunk($this->data, $this->line_length);
        foreach ($arr as $line) {
            echo "|";
            foreach ($line as $cell) {
                echo ($cell !== self::INIT_CELL) ? $cell : " ";
                echo "|";
            }
            echo PHP_EOL;
        }
    }

    public function put(string $p, int $a, int $b): bool
    {
        $idx = $b + ($a * $this->line_length);

        if ($a >= $this->line_length || $b >= $this->line_length) {
            throw new \InvalidArgumentException('座標軸が存在しない');
        }

        if ($this->data[$idx] !== self::INIT_CELL) {
            throw new \LogicException('すでに置いてある');
        }

        $this->data[$idx] = $p;

        return true;
    }
}
