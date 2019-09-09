<?php

namespace Gmk\Libs;

interface GameRulerInterface
{
    const BOARD_RANGE = 10;
    const WIN_CONDITION_COUNT = 5;

    public function announce(string $text): void;

    public function parseArgsXY(string $str);

    public function judgement(string $stone, array $arr): bool;

    public function getRowIndexes(int $idx): array;

    public function getColIndexes(int $idx): array;

    public function getRightDiagonalIndexes(int $idx): array;

    public function getLeftDiagonalIndexes(int $idx): array;
}
