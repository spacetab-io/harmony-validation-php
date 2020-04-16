<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Network\IpAddress;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\IpAddress\Ipv4;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class Ipv4Test extends StringTestCase
{
    /**
     * Ipv4Test constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Ipv4::class);
    }

    public function testValidateFailsWhenPassingAnIpv6Address(): Generator
    {
        /** @var Result $result */
        $result = yield (new Ipv4())->validate('2001:0db8:85a3:0000:0000:8a2e:0370:7334');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.IpAddress.Ipv4', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnInvalidIpv4Address(): Generator
    {
        /** @var Result $result */
        $result = yield (new Ipv4())->validate('x.1.2.3');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.IpAddress.Ipv4', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIpv4Address(): Generator
    {
        /** @var Result $result */
        $result = yield (new Ipv4())->validate('192.168.1.1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
