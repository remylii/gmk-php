<?php

namespace Gmk\Libs;

interface GameRulerInterface
{
    public function parseArgsXY(string $str);

    public function judgement(string $stone, array $arr): bool;
}
