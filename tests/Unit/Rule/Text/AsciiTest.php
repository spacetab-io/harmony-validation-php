<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Text;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Text\Ascii;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class AsciiTest extends StringTestCase
{
    /**
     * AsciiTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Ascii::class);
    }

    public function testValidateFailsWhenPassingAnUtf8String(): Generator
    {
        /** @var Result $result */
        $result = yield (new Ascii())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.Ascii', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnAsciiString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Ascii())->validate(
            ' !"#$%&\\\'() * +,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\] ^ _`abcdefghijklmnopqrstuvwxyz{|}~'
        );

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
