<?php
// tests/CalculatorTest.php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../calculator.php';

class CalculatorTest extends TestCase {
    private Calculator $calc;

    protected function setUp(): void {
        $this->calc = new Calculator();
    }

    public function testAddition() {
        $this->assertEquals(5, $this->calc->calculate("2+3"));
    }

    public function testSubtraction() {
        $this->assertEquals(1, $this->calc->calculate("4-3"));
    }

    public function testMultiplication() {
        $this->assertEquals(12, $this->calc->calculate("3*4"));
    }

    public function testDivision() {
        $this->assertEquals(2, $this->calc->calculate("8/4"));
    }

    public function testOperatorPrecedence() {
        $this->assertEquals(14, $this->calc->calculate("2+3*4"));
    }

    public function testParentheses() {
        $this->assertEquals(20, $this->calc->calculate("(2+3)*4"));
    }

    public function testDivisionByZeroThrows() {
        $this->expectException(RuntimeException::class);
        $this->calc->calculate("5/0");
    }

    public function testInvalidExpressionThrows() {
        $this->expectException(RuntimeException::class);
        $this->calc->calculate("2+bad");
    }

    public function testEmptyStringThrows() {
        $this->expectException(RuntimeException::class);
        $this->calc->calculate("");
    }
}
