<?php
namespace Gmk;

class GameManager
{
    public function start()
    {
        /** 登場人物を整理させる */
        // 盤面, 置く石, プレイヤー

        /** ゲームのシナリオを整理させる */
        while (true) {
            // 1. ボード表示
            echo "現在の盤面を表示して\n";

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
