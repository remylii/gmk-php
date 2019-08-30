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
        // 盤面, 置く石, プレイヤー

        /** ゲームのシナリオを整理させる */
        while (true) {
            // 1. ボード表示
            $this->board->show();

            // 2. 色ぬり
            echo "このターンのプレイヤーが石を置く\n";

            // 3. 勝敗判定
            echo "勝敗が決したか確認する\n";

            // 4. 相手のターン
            echo "勝負がついていなければ相手のターン\n";

            // 5. 繰り返し

            return;
        }
    }
}
