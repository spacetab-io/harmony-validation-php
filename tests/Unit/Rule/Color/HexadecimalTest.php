<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Color;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Color\Hexadecimal;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class HexadecimalTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Hexadecimal::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithPoundSign()
    {
        /** @var Result $result */
        $result = yield (new Hexadecimal())->validate('ff3300');

        $this->assertFalse($result->isValid());
        $this->assertSame('Color.Hexadecimal', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringContainsACharacterOutsideOfTheHexRange()
    {
        /** @var Result $result */
        $result = yield (new Hexadecimal())->validate('#gf3300');

        $this->assertFalse($result->isValid());
        $this->assertSame('Color.Hexadecimal', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenValueIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Hexadecimal())->validate('#ff330');

        $this->assertFalse($result->isValid());
        $this->assertSame('Color.Hexadecimal', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenValueIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Hexadecimal())->validate('#ff33000');

        $this->assertFalse($result->isValid());
        $this->assertSame('Color.Hexadecimal', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsOnValidLowerCaseValue()
    {
        /** @var Result $result */
        $result = yield (new Hexadecimal())->validate('#ff3300');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsOnValidUpperCaseValue()
    {
        /** @var Result $result */
        $result = yield (new Hexadecimal())->validate('#FF3300');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
