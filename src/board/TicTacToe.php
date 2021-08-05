<?php

use board\Board;
use board\Mark;
use players\IPlayer;

class TicTacToe {

    private Board $board;
    private GameUi $ui;
    private IPlayer $lastPlayer;
    private IPlayer $player1;
    private IPlayer $player2;

    public function __construct(
        Board $board,
        GameUi $ui,
        IPlayer $player1,
        IPlayer $player2
    )
    {
        $this->board = $board;
        $this->ui = $ui;

        $player1->setMark(Mark::X);
        $player2->setMark(Mark::O);
        $player1->setColor('yellow');
        $player2->setColor('blue');

        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    public function start()
    {
        $gameState = -1;
        $this->ui->drawGrid($this->board->getGrid());
        $gameOver = false;
        while ($gameOver === false) {
            $player = $this->getPlayer();

            $this->ui->notifyPlayerTurn(
                $player->getName(),
                $player->getMark(),
                $player->getColor(),
                $player->isHuman()
            );

            try {
                $player->move($this->board);
            } catch (Exception $e) {
                $this->ui->printException($e);
            }

            $this->ui->drawGrid($this->board->getGrid());
            $this->lastPlayer = $player;
            $evaluation = $this->board->evaluate($this->lastPlayer->getMark());
            if ($evaluation !== 0) {
                $this->ui->printGameResult("{$this->lastPlayer->getName()} wins the game!!");
                $gameOver = true;
            }
            if ( ! $this->board->isMovesLeft()) {
                $this->ui->printGameResult('Game was a draw');
                $gameOver = true;
            }
        }


    }

    private function getPlayer():IPlayer
    {
        // For the first move select a random player
        if ($this->board->getMoves() === 0) {
            return ((rand(0, 1) === 0)
                ? $this->player1
                : $this->player2
            );
        }

        return (($this->lastPlayer === $this->player2)
            ? $this->player1
            : $this->player2
        );
    }
}