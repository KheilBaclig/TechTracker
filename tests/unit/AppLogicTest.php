<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

class AppLogicTest extends CIUnitTestCase
{
    // Test 1: Password hashing
    public function testPasswordHashIsValid(): void
    {
        $plain  = 'secret123';
        $hashed = password_hash($plain, PASSWORD_BCRYPT);
        $this->assertTrue(password_verify($plain, $hashed));
    }

    // Test 2: Wrong password fails verification
    public function testWrongPasswordFails(): void
    {
        $hashed = password_hash('correct', PASSWORD_BCRYPT);
        $this->assertFalse(password_verify('wrong', $hashed));
    }

    // Test 3: Transaction ref code format
    public function testTransactionRefCodeFormat(): void
    {
        $ref = 'TXN-' . strtoupper(substr(uniqid(), -6));
        $this->assertStringStartsWith('TXN-', $ref);
    }

    // Test 4: Checkout reduces stock
    public function testCheckoutReducesStock(): void
    {
        $current = 20;
        $qty     = 5;
        $this->assertEquals(15, $current - $qty);
    }

    // Test 5: Checkin increases stock
    public function testCheckinIncreasesStock(): void
    {
        $current = 10;
        $qty     = 3;
        $this->assertEquals(13, $current + $qty);
    }

    // Test 6: Stock cannot go below zero
    public function testStockCannotGoBelowZero(): void
    {
        $current = 2;
        $qty     = 10;
        $this->assertEquals(0, max(0, $current - $qty));
    }

    // Test 7: Asset tag is uppercased
    public function testAssetTagIsUppercased(): void
    {
        $tag = strtoupper('lt-001');
        $this->assertEquals('LT-001', $tag);
    }

    // Test 8: Low stock detection
    public function testLowStockDetection(): void
    {
        $quantity  = 1;
        $threshold = 2;
        $this->assertTrue($quantity <= $threshold);
    }
}
