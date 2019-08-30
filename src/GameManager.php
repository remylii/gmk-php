<?php
namespace Gmk;

use Gmk\Board;

class GameManager
{
    private $board;

    public function __construct()
    {
        $this->board = new Board(10);
    }

    public function start()
    {
        /** 登場人物を整理させる */

        /** ゲームのシナリオを整理させる */
        $stones = ["●", "○"];
        while (true) {
            foreach ($stones as $stone) {
                echo $stone . "のターン" . PHP_EOL;
                // 1. ボード表示
                $this->board->show();

                // 2. 色ぬり
                echo "座標を「x,y」の形で入力してください..." . PHP_EOL;
                while (true) {
                    try {
                        $stdin = trim(fgets(STDIN));
                        list($x, $y) = $this->parseArgsXY($stdin);
                        $this->board->put($stone, $x, $y);
                    } catch (\InvalidArgumentException | \LogicException $e) {
                        echo $e->getMessage() . PHP_EOL;
                        continue;
                    }

                    break 1;
                }

                // 3. 勝敗判定

                // 4. 相手のターン
            }
            // 5. 繰り返し
        }
    }

    private function parseArgsXY(string $str)
    {
        if (!preg_match("/^(\d+),(\d+)$/", $str, $res)) {
            throw new \InvalidArgumentException('入力の形が違う');
        }

        return [$res[1], $res[2]];
    }
}
