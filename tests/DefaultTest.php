<?php


use PHPUnit\Framework\TestCase;

class DefaultTest extends TestCase
{

    /** @test */
    public function justChecking()
    {
        $this->assertEquals(1,1);
    }
}