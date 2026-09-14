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

    public function testRequiredFieldPassesWhenFilled(): void
    {
        $validator = new Validator();

        $this->assertTrue($validator->validate(['name' => 'Clavier'], ['name' => ['required']]));
    }

    public function testNumericRuleRejectsNonNumericValue(): void
    {
        $validator = new Validator();

        $this->assertFalse($validator->validate(['price' => 'abc'], ['price' => ['numeric']]));
        $this->assertSame('Ce champ doit être un nombre.', $validator->errorsFor('price')[0]);
    }

    public function testMaxLengthRuleRejectsTooLongValue(): void
    {
        $validator = new Validator();

        $this->assertFalse($validator->validate(['name' => 'Clavier'], ['name' => ['maxLength:3']]));
        $this->assertSame(
            'Ce champ ne doit pas dépasser 3 caractères.',
            $validator->errorsFor('name')[0]
        );
    }

    public function testMinLengthAndEmailRules(): void
    {
        $validator = new Validator();

        $this->assertFalse($validator->validate(
            ['name' => 'A', 'email' => 'invalid'],
            ['name' => ['minLength:2'], 'email' => ['email']]
        ));
        $this->assertCount(1, $validator->errorsFor('name'));
        $this->assertCount(1, $validator->errorsFor('email'));
    }
}