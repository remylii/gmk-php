<?php
namespace Gmk;

use Gmk\Board;
use Gmk\Libs\GameRulerInterface;

class GameManager implements GameRulerInterface
{
    use Libs\GameRulerTrait;

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
                echo "座標を「x,y」の形で入力してください...  ";
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
                if ($this->judgement($stone, $this->board->getData())) {
                    echo $stone . "の勝利" . PHP_EOL;
                    $this->board->show();
                    exit(0);
                }

                // 4. 相手のターン
            }
            // 5. 繰り返し
        }
    }
}
