<?php


namespace players;


use board\Board;
use Exception;


class Player implements IPlayer
{
    private String $name;
    private string $mark;
    private string $color;

    public function __construct(String $name = "Human")
    {
        $this->name = $name;
    }

    /**
     * @throws Exception
     */
    public function move(Board $board): void
    {
        $input = trim(fgets(STDIN));
        $board->update($this->mark, $input);
    }

    public function isHuman(): bool
    {
        return true;
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
}