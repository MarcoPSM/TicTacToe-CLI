<?php


namespace players;


use board\Board;
use board\Mark;
use Exception;

class PlayerAI implements IPlayer
{
    private String $name;
    private string $mark;
    private string $opponent;
    private string $color;

    public function __construct(String $name = "Robot")
    {
        $this->name = $name;
    }

    /**
     * @throws Exception
     */
    public function move(Board $board): void
    {
        $this->opponent = $this->mark === Mark::O ? Mark::X : Mark::O;
        $input = $this->getBestMove($board);

        $board->update($this->mark, $input);
    }

    public function isHuman(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMark(): string
    {
        return $this->mark;
    }
    public function getColor(): string
    {
        return $this->color;
    }

    public function setMark(string $mark): void
    {
        $this->mark = $mark;
    }
    public function setColor(string $color): void
    {
        $this->color = $color;
    }


    private function getBestMove(Board $board):string
    {
        $bestMove = [];
        $bestValue = PHP_INT_MIN;
        $grid = $board->getGrid();
        $boardSide = $board->getBoardSide();

        for ($i=0; $i < $boardSide; $i++) {
            for ($j=0; $j < $boardSide; $j++) {
                if ($grid[$i][$j] === Mark::BLANK) {
                    $board->setCell($i, $j, $this->mark);
                    $value = $this->miniMax($board, 0, false);

                    $board->setCell($i, $j, Mark::BLANK);

                    if ($value > $bestValue) {
                        // Grid index starts at 1.
                        // We add 1 for consistency with human players
                        $bestMove = [$i+1, $j+1];
                        $bestValue = $value;
                    }
                }
            }
        }
        return $bestMove[0] . $bestMove[1];
    }

    private function miniMax(Board $board, int $depth, bool $isMax):int
    {
        $grid = $board->getGrid();
        $boardSide = $board->getBoardSide();
        //$score = $this->evaluate($grid, $depth);
        $score = $board->evaluate($this->mark);

        if ($score !== 0) {
            return $score;
        }
        if (! $board->isMovesLeft()) {
            return 0;
        }

        if ($isMax) {
            $best = PHP_INT_MIN;
            for ($i=0; $i < $boardSide; $i++) {
                for ($j=0; $j < $boardSide; $j++) {
                    if ($grid[$i][$j] === Mark::BLANK) {
                        $board->setCell($i, $j, $this->mark);
                        $grid[$i][$j] = $this->mark;
                        $best = max($best, $this->miniMax($board, $depth + 1, !$isMax));
                        $board->setCell($i, $j, Mark::BLANK);
                    }
                }
            }

            // Given 2 moves with score 10,
            // chose the shortest path
            return $best - $depth;
        } else {
            $best = PHP_INT_MAX;
            for ($i=0; $i < $boardSide; $i++) {
                for ($j=0; $j < $boardSide; $j++) {
                    if ($grid[$i][$j] === Mark::BLANK) {
                        $board->setCell($i, $j, $this->opponent);
                        $best = min($best, $this->miniMax($board, $depth + 1, !$isMax));
                        $board->setCell($i, $j, Mark::BLANK);
                    }
                }
            }

            return $best + $depth;
        }
    }


    private function evaluate(array $grid, int $moves):int
    {
        $score = [
            $this->mark => 10,
            $this->opponent => -10
        ];

        if ($grid[0][0] !== Mark::BLANK) {
            // First row
            if ($grid[0][0] === $grid[0][1] && $grid[0][1] === $grid[0][2]) {
                return $score[ $grid[0][0] ];
            }

            // First column
            if ($grid[0][0] === $grid[1][0] && $grid[1][0] === $grid[2][0]) {
                return  $score[ $grid[0][0] ];
            }

            // Diagonal left to right
            if ($grid[0][0] === $grid[1][1] && $grid[1][1] === $grid[2][2]) {
                return $score[ $grid[0][0] ];
            }
        }

        if ($grid[1][1] !== Mark::BLANK) {
            // Middle row
            if ($grid[1][0] === $grid[1][1] && $grid[1][1] === $grid[1][2]) {
                return $score[ $grid[1][1] ];
            }

            // Middle column
            if ($grid[0][1] === $grid[1][1] && $grid[1][1] === $grid[2][1]) {
                return $score[ $grid[1][1] ];
            }

            // Diagonal right to left
            if ($grid[0][2] === $grid[1][1] && $grid[1][1] === $grid[2][0]) {
                return $score[ $grid[1][1] ];
            }
        }

        if ($grid[2][2] !== Mark::BLANK) {
            // Last row
            if ($grid[2][0] === $grid[2][1] && $grid[2][1] === $grid[2][2]) {
                return $score[ $grid[2][2] ];
            }

            // Last column
            if ($grid[0][2] === $grid[1][2] && $grid[1][2] === $grid[2][2]) {
                return $score[ $grid[2][2] ];
            }
        }

        if ($moves === 9) {
            return 0;
        }

        return 1;
    }

}