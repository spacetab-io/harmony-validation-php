<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Network\IpAddress;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\IpAddress\Ipv6;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class Ipv6Test extends StringTestCase
{
    /**
     * Ipv6Test constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Ipv6::class);
    }

    public function testValidateFailsWhenPassingAnIpv4Address(): Generator
    {
        /** @var Result $result */
        $result = yield (new Ipv6())->validate('192.168.1.1');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.IpAddress.Ipv6', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnInvalidIpv6Address(): Generator
    {
        /** @var Result $result */
        $result = yield (new Ipv6())->validate('x001:0db8:85a3:0000:0000:8a2e:0370:7334');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.IpAddress.Ipv6', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIpv6Address(): Generator
    {
        /** @var Result $result */
        $result = yield (new Ipv6())->validate('2001:0db8:85a3:0000:0000:8a2e:0370:7334');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
