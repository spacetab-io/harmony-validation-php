<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Isbn;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Isbn\Isbn10;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class Isbn10Test extends StringTestCase
{
    /**
     * Isbn10Test constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Isbn10::class);
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn10())->validate('897013750');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn10', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn10())->validate('89701375066');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn10', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringContainsInvalidCharacters(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn10())->validate('897013750y');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn10', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumDoesNotMatch(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn10())->validate('0345391803');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn10', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsTrueWhenValid(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn10())->validate('0345391802');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenValidWithLowercaseCheckDigitX(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn10())->validate('043942089x');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenValidWithUppercaseCheckDigitX(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn10())->validate('043942089X');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
