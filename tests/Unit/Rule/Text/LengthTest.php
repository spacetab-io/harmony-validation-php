<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Text;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Text\Length;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class LengthTest extends StringTestCase
{
    /**
     * LengthTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Length::class, 10);
    }

    public function testValidateFailsWhenPassingAStringSmallerThanTheLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new Length(10))->validate('€€€€€€€€€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.Length', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAStringLongerThanTheLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new Length(10))->validate('€€€€€€€€€€€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.Length', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAStringWithExactlyTheLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new Length(10))->validate('€€€€€€€€€€');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
