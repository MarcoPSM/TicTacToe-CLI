<?php
namespace players;

use board\Board;

interface IPlayer {

    public function move(Board $board): void;
    public function isHuman(): bool;
    public function getName(): string;
    public function getMark(): string;
    public function getColor(): string;
    public function setMark(string $mark): void;
    public function setColor(string $color): void;
}
