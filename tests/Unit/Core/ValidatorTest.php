<?php
// tests/Unit/Core/ValidatorTest.php
namespace Tests\Unit\Core;

use Core\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testRequiredFieldFailsWhenEmpty(): void
    {
        $validator = new Validator();
        $isValid = $validator->validate(['name' => ''], ['name' => ['required']]);

        $this->assertFalse($isValid);
    }
}