<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Isbn;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Isbn\Isbn13;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class Isbn13Test extends StringTestCase
{
    /**
     * Isbn13Test constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Isbn13::class);
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn13())->validate('978897013750');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn13', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn13())->validate('97889701375066');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn13', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringContainsInvalidCharacters(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn13())->validate('978897013750x');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn13', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumDoesNotMatch(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn13())->validate('9788970137507');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn13', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenValid(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn13())->validate('9788970137506');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
