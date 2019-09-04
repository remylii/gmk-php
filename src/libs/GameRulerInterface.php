<?php

namespace Gmk\Libs;

interface GameRulerInterface
{
    public function announce(string $text): void;

    public function parseArgsXY(string $str);

    public function judgement(string $stone, array $arr): bool;
}
