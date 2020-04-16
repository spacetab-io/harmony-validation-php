<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Text;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Text\AlphaNumeric;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class AlphaNumericTest extends StringTestCase
{
    /**
     * AlphaNumericTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, AlphaNumeric::class);
    }

    public function testValidateFailsWhenPassingANonAlphaNumericalString(): Generator
    {
        /** @var Result $result */
        $result = yield (new AlphaNumeric())->validate(' sdakjhsakh3287632786378');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.AlphaNumeric', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnAlphaNumericalString(): Generator
    {
        /** @var Result $result */
        $result = yield (new AlphaNumeric())->validate('sdakjhsakh3287632786378');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
