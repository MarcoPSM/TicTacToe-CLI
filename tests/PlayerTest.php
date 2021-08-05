<?php


use board\Mark;
use players\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{

    /** @test */
    public function playerMustBeHuman()
    {
        $player = new Player("Marco");
        $this->assertTrue($player->isHuman());
        $player = new Player();
        $this->assertTrue($player->isHuman());
    }

    /** @test */
    public function playerName()
    {
        $player = new Player();
        $this->assertEquals("Human", $player->getName());
        $player = new Player("Tester");
        $this->assertEquals("Tester", $player->getName());
    }

    /** @test */
    public function playerMark()
    {
        $player = new Player();
        $player->setMark(Mark::X);
        $this->assertEquals('X', $player->getMark());

        $player->setMark(Mark::O);
        $this->assertEquals('O', $player->getMark());
    }

    /** @test */
    public function playerColor()
    {
        $player = new Player();
        $player->setColor("red");
        $this->assertEquals('red', $player->getColor());
    }
}
