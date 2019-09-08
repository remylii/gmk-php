<?php
namespace Gmk;

use Gmk\Board;
use Gmk\Player;
use Gmk\Libs\GameRulerInterface;

class GameManager implements GameRulerInterface
{
    use Libs\GameRulerTrait;

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

    public function start(): bool
    {
        while (true) {
            foreach ($this->players as $player) {
                $this->announce($player->getName() . "のターン". PHP_EOL);
                $this->board->show();

                while (true) {
                    $this->announce("座標を「x,y」で入力してください... ");

                    try {
                        $stdin = trim(fgets(STDIN));
                        list($a, $b) = $this->parseArgsXY($stdin);
                        $this->board->put($player->getStone(), $a, $b);
                    } catch (\InvalidArgumentException | \LogicException $e) {
                        echo $e->getMessage() . PHP_EOL;
                        continue;
                    } catch (\Throwable $e) {
                        throw $e;
                    }

                    break 1;
                }

                if ($this->judgement($player->getStone(), $this->board->getData())) {
                    $this->announce($player->getName() . 'の勝利!' . PHP_EOL);
                    $this->board->show();
                    break 2;
                }
            }
        }

        return true;
    }
}
