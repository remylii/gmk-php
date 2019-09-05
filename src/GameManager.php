<?php
namespace Gmk;

use Gmk\Board;
use Gmk\Player;
use Gmk\Libs\GameRulerInterface;

class GameManager implements GameRulerInterface
{
    use Libs\GameRulerTrait;

    const BOARD_RANGE = 10;
    const BLACK_STONE = '●';
    const WHITE_STONE = '○';

    /** @var Board */
    private $board;

    /** @var array <Player> */
    private $players;

    public function __construct()
    {
        $this->board = new Board(self::BOARD_RANGE);
        $this->players = [
            new Player('Player A', self::BLACK_STONE),
            new Player('Player B', self::WHITE_STONE)
        ];
    }

    public function start()
    {
        while (true) {
            foreach ($this->players as $player) {
                $this->board->show();

                $this->announce(
                    $player->getName() . "のターン". PHP_EOL
                    . "座標を「x,y」で入力してください... "
                );

                while (true) {
                    try {
                        $stdin = trim(fgets(STDIN));
                        list($x, $y) = $this->parseArgsXY($stdin);
                        $this->board->put($player->getStone(), $x, $y);
                    } catch (\InvalidArgumentException | \LogicException $e) {
                        echo $e->getMessage() . PHP_EOL;
                        continue;
                    }

                    break 1;
                }

                if ($this->judgement($player->getStone(), $this->board->getData())) {
                    $this->announce($player->getName() . 'の勝利!' . PHP_EOL);
                    $this->board->show();
                    exit(0);
                }
            }
        }
    }
}
