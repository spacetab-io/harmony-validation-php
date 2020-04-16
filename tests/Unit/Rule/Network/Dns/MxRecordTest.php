<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Network\Dns;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\Dns\MxRecord;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class MxRecordTest extends StringTestCase
{
    /**
     * MxRecordTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, MxRecord::class);
    }

    public function testValidateFailsWhenPassingADomainWithoutAnMxRecord(): Generator
    {
        /** @var Result $result */
        $result = yield (new MxRecord())->validate('example123.com');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Dns.MxRecord', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingADomainWithAnMxRecord(): Generator
    {
        /** @var Result $result */
        $result = yield (new MxRecord())->validate('gmail.com');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
