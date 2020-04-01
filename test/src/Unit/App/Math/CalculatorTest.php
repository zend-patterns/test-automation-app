<?php

namespace Test\Unit\Zf1Compat\App\Math;

use App\Math\Calculator;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    /**
     * @var Calculator
     */
    private $calculator;

    public function setUp()
    {
        $this->calculator = new Calculator();
    }

    public function testAdd()
    {
        self::assertEquals(3, $this->calculator->add(2,1));
    }
}
