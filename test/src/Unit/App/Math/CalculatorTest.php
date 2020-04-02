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

    public function dataProvider(): array
    {
        return [
            [2],
            [20],
            [500],
            [PHP_INT_MAX]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAdd_Increment_GreaterThan(int $value)
    {
        self::assertGreaterThan($value, $this->calculator->add($value, 1));
    }
}
