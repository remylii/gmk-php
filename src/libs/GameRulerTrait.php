<?php

namespace Gmk\Libs;

trait GameRulerTrait
{
    public function parseArgsXY(string $str)
    {
        if (!preg_match("/^(\d+),(\d+)$/", $str, $res)) {
            throw new \InvalidArgumentException('入力の形が違う');
        }

        return [$res[1], $res[2]];
    }

    public function judgement($stone, $arr): bool
    {
        $win_count = 2;
        $win_flag = false;

        foreach ($arr as $line_idx => $line) {
            if (array_search($stone, $line, true) === false) {
                continue;
            }

            $line_same = 0;
            foreach ($line as $idx => $cell) {
                if ($cell !== $stone) {
                    $line_same = 0;
                    continue;
                }

                $line_same++;

                // 縦
                $row_flag = true;
                for ($i = 1; $i < $win_count; $i++) {
                    if ($arr[($line_idx + $i)][$idx] !== $stone) {
                        $row_flag = false;
                        break;
                    }
                }

                if ($line_same >= $win_count || $row_flag === true) {
                    $win_flag = true;
                    break 2;
                }
            }
        }

        return $win_flag;
    }
}
