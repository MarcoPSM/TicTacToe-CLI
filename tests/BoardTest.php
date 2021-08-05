<?php


use board\Board;
use board\Mark;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    /** @test */
    public function boardDimensions()
    {
        $board = new Board();
        $grid = $board->getGrid();
        $totalSize = 0;
        foreach ($grid as $line) {
            $this->assertSameSize($grid, $line);
        }
    }

    /** @test */
    public function movesIsInt()
    {
        $board = new Board();
        $this->assertIsInt($board->getMoves());
    }

    /** @test */
    public function checkMovesLeft()
    {
        $board = new Board();
        $boardSide = $board->getBoardSide();
        $this->assertTrue($board->isMovesLeft());
        for ($i=0; $i < $boardSide; $i++) {
            for ($j = 0; $j < $boardSide; $j++) {
                $board->setCell($i, $j, Mark::X);
            }
        }
        $this->assertFalse($board->isMovesLeft());
    }

    /** @test
     * @throws Exception
     */
    public function checkEvaluation()
    {
        //line
        $board = new Board();
        $this->assertEquals(0, $board->evaluate(Mark::X));
        $board->update(Mark::X, '11');
        $board->update(Mark::X, '12');
        $board->update(Mark::X, '13');
        $this->assertEquals(10, $board->evaluate(Mark::X));
        $this->assertEquals(-10, $board->evaluate(Mark::O));

        //column
        $board = new Board();
        $board->update(Mark::O, '13');
        $board->update(Mark::O, '23');
        $board->update(Mark::O, '33');
        $this->assertEquals(10, $board->evaluate(Mark::O));
        $this->assertEquals(-10, $board->evaluate(Mark::X));

        //diagonal
        $board = new Board();
        $this->assertEquals(0, $board->evaluate(Mark::X));
        $board->update(Mark::X, '11');
        $board->update(Mark::X, '22');
        $board->update(Mark::X, '33');
        $this->assertEquals(10, $board->evaluate(Mark::X));
        $this->assertEquals(-10, $board->evaluate(Mark::O));

        //diagonal2
        $board = new Board();
        $board->update(Mark::O, '13');
        $board->update(Mark::O, '22');
        $board->update(Mark::O, '31');
        $this->assertEquals(10, $board->evaluate(Mark::O));
        $this->assertEquals(-10, $board->evaluate(Mark::X));
    }

    /** @test
     * @throws ReflectionException
     */
    public function checkIncrementMoves()
    {
        /** private method */
        $board = new Board();
        $this->invokeBoardMethod($board, 'incrementMoves');
        $this->assertEquals(1, $board->getMoves());
        $this->invokeBoardMethod($board, 'incrementMoves');
        $this->assertEquals(2, $board->getMoves());
    }

    /**
     * Method to call private and protected methods
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return void
     * @throws ReflectionException
     */
    private function invokeBoardMethod(&$object, $methodName, array $parameters = array()): void
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        $method->invokeArgs($object, $parameters);
    }

}
