<?php

namespace Gmk\Libs;

trait GameRulerTrait
{
    public function announce(string $text): void
    {
        echo $text;
    }

    public function parseArgsXY(string $str)
    {
        if (!preg_match("/^(\d+),(\d+)$/", $str, $res)) {
            throw new \InvalidArgumentException('入力の形が違う');
        }

        return [(int)$res[2], (int)$res[1]];
    }

    public function judgement($stone, $elements): bool
    {
        $range = self::BOARD_RANGE ** 2;
        $win_flag = false;

        $values = array_count_values($elements);

        if (!isset($values[$stone]) || $values[$stone] < self::WIN_CONDITION_COUNT) {
            return false;
        }

        for ($i = 0; $i < ($range - self::WIN_CONDITION_COUNT); $i++) {
            if ($elements[$i] !== $stone) {
                continue;
            }

            foreach (['row', 'col', 'r_diagonal', 'l_diagonal'] as $type) {
                $flag = true;
                $indexes = [];
                switch ($type) {
                    case "row":
                        $indexes = $this->getRowIndexes($i);
                        break;
                    case "col":
                        $indexes = $this->getColIndexes($i);
                        break;
                    case "r_diagonal":
                        $indexes = $this->getRightDiagonalIndexes($i);
                        break;
                    case "l_diagonal":
                        $indexes = $this->getLeftDiagonalIndexes($i);
                        break;
                }

                foreach ($indexes as $j) {
                    if (isset($elements[$j]) && $elements[$j] !== $stone) {
                        $flag = false;
                        break;
                    }
                }

                if ($flag === true) {
                    $win_flag = true;
                    break 2;
                }
            }
        }

        return $win_flag;
    }

    public function getRowIndexes(int $idx): array
    {
        $n = 1;
        return $this->getIndexes($idx, $n);
    }

    public function getColIndexes(int $idx): array
    {
        $n = self::BOARD_RANGE;
        return $this->getIndexes($idx, $n);
    }

    public function getRightDiagonalIndexes(int $idx): array
    {
        $n = self::BOARD_RANGE + 1;
        return $this->getIndexes($idx, $n);
    }

    public function getLeftDiagonalIndexes(int $idx): array
    {
        $n = self::BOARD_RANGE - 1;
        return $this->getIndexes($idx, $n);
    }

    private function getIndexes(int $idx, int $n): array
    {
        $res = [$idx];
        for ($i = 1; $i < self::WIN_CONDITION_COUNT; $i++) {
            array_push($res, $idx + ($i * $n));
        }

        return array_reverse($res);
    }
}
