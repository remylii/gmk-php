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

            foreach (['row', 'raw', 'r_slash', 'l_slash'] as $type) {
                $flag = true;
                $ids = $this->getIndexes($type, $i);

                foreach ($ids as $j) {
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

    public function getIndexes($type, $idx)
    {
        switch ($type) {
            case 'row':
                $n = 1;
                break;
            case 'raw':
                $n = self::BOARD_RANGE;
                break;
            case 'r_slash':
                $n = self::BOARD_RANGE + 1;
                break;
            case 'l_slash':
                $n = self::BOARD_RANGE - 1;
                break;
            default:
                $n = 0;
                break;
        }

        $res = [$idx];
        for ($i = 1; $i < self::WIN_CONDITION_COUNT; $i++) {
            $res[] = $idx + ($i * $n);
        }
        return array_reverse($res);
    }
}
