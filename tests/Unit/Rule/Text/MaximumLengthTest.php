<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Text;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Text\MaximumLength;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class MaximumLengthTest extends StringTestCase
{
    /**
     * MaximumLengthTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, MaximumLength::class, 10);
    }

    public function testValidateFailsWhenPassingAStringLongerThanTheMaximumLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(10))->validate('€€€€€€€€€€€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.MaximumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAStringSmallerThanTheMaximumLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(10))->validate('€€€€€€€€€');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAStringWithExactlyTheMaximumLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(10))->validate('€€€€€€€€€€');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
