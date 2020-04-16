<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Isbn;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Isbn\Isbn;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class IsbnTest extends StringTestCase
{
    /**
     * IsbnTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Isbn::class);
    }

    public function testValidateFailsWhenPassingInAnInvalidIsbn10(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn())->validate('0345391803');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInAnInvalidIsbn13(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn())->validate('9788970137507');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingInAValidIsbn10(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn())->validate('0345391802');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingInAValidIsbn13(): Generator
    {
        /** @var Result $result */
        $result = yield (new Isbn())->validate('9788970137506');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
