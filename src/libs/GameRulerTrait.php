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

        return [(int)$res[1], (int)$res[2]];
    }

    public function judgement($stone, $arr): bool
    {
        $win_count = 5;
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
                    if (!isset($arr[($line_idx + $i)])) {
                        $row_flag = false;
                        break;
                    }

                    if ($arr[($line_idx + $i)][$idx] !== $stone) {
                        $row_flag = false;
                        break;
                    }
                }

                // 右斜め
                $slash_flag = true;
                for ($i = 1; $i < $win_count; $i++) {
                    if (!isset($arr[($line_idx + $i)]) || !isset($arr[$line_idx + $i][($idx + $i)])) {
                        $slash_flag = false;
                        break;
                    }

                    if ($arr[($line_idx + $i)][($idx + $i)] !== $stone) {
                        $slash_flag = false;
                        break;
                    }
                }

                // 左斜め
                $left_slash_flag = true;
                for ($i = 1; $i < $win_count; $i++) {
                    if (!isset($arr[($line_idx + $i)]) || !isset($arr[($line_idx + $i)][($idx - $i)])) {
                        $left_slash_flag = false;
                        break;
                    }

                    if ($arr[($line_idx + $i)][($idx - $i)] !== $stone) {
                        $left_slash_flag = false;
                        break;
                    }
                }

                if ($line_same >= $win_count || $row_flag === true || $slash_flag === true || $left_slash_flag === true) {
                    $win_flag = true;
                    break 2;
                }
            }
        }

        return $win_flag;
    }
}
