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

    public function testAdd_Increment_GreaterThan()
    {
        self::assertGreaterThan(2, $this->calculator->add(2,1));
//        self::assertGreaterThan(9223372036854775807, $this->calculator->add(9223372036854775807,1));
    }
}
