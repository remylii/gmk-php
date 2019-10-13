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

    public function judge(int $idx, array $elements): bool
    {
        $indexes = [
            self::BOARD_RANGE + 1,
            self::BOARD_RANGE,
            self::BOARD_RANGE - 1,
            1
        ];

        if (!isset($elements[$idx])) {
            return false;
        }
        $s = $elements[$idx];
        $idx_n = (int)substr($idx, -1); // 一桁目

        foreach ($indexes as $index) {
            $round = 0;
            $same_count = 1;
            while ($round < 2) {
                $base = ($round === 0) ? $index : -($index);

                if ($idx_n === self::BOARD_RANGE - 1) {
                    if ($base === -(self::BOARD_RANGE - 1) || $base === 1 || $base === self::BOARD_RANGE + 1) {
                        $round++;
                        continue;
                    }
                } elseif (($idx%self::BOARD_RANGE) === 0) {
                    if ($base === -(self::BOARD_RANGE + 1) || $base === -1 || $base === self::BOARD_RANGE - 1) {
                        $round++;
                        continue;
                    }
                }

                for ($i = 1; $i < self::WIN_CONDITION_COUNT; $i++) {
                    $target_idx = $idx + ($base * $i);
                    if ($target_idx < 0 || $elements[$target_idx] !== $s) {
                        break 1;
                    }
                    $same_count++;

                    $n = (int)substr($target_idx, -1);
                    if ($n === self::BOARD_RANGE) {
                        if ($base === -(self::BOARD_RANGE - 1) || $base === 1 || $base == self::BOARD_RANGE + 1) {
                            break 1;
                        }
                    }

                    if (($target_idx % self::BOARD_RANGE) === 0) {
                        if ($base === -(self::BOARD_RANGE + 1) || $base === -1 || $base === self::BOARD_RANGE - 1) {
                            break 1;
                        }
                    }
                }

                $round++;
            }

            if ($same_count >= self::WIN_CONDITION_COUNT) {
                return true;
            }
        }

        return false;
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
