<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Network\Dns;

use Generator;
use HarmonyIO\Validation\Enum\Network\Dns\RecordType;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\Dns\RecordExists;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class RecordExistsTest extends StringTestCase
{
    /**
     * RecordExistsTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, RecordExists::class, RecordType::MX());
    }

    public function testValidateFailsWhenPassingADomainWithoutAnMxRecord(): Generator
    {
        /** @var Result $result */
        $result = yield (new RecordExists(RecordType::MX()))->validate('example123.com');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Dns.RecordExists', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingADomainWithAnMxRecord(): Generator
    {
        /** @var Result $result */
        $result = yield (new RecordExists(RecordType::MX()))->validate('gmail.com');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
