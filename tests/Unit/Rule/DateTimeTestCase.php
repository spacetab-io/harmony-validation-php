<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;

class DateTimeTestCase extends AsyncTestCase
{
    /** @var string */
    private $classUnderTest;

    /** @var array<mixed> */
    private $parameters = [];

    /** @var Rule */
    private $testObject;

    /**
     * DateTimeTestCase constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     * @param string $classUnderTest
     * @param mixed ...$parameters
     */
    public function __construct(
        ?string $name,
        array $data,
        $dataName,
        string $classUnderTest,
        ...$parameters
    ) {
        $this->classUnderTest = $classUnderTest;
        $this->parameters     = $parameters;

        parent::__construct($name, $data, $dataName);
    }

    public function setUp(): void
    {
        parent::setUp();

        $className = $this->classUnderTest;

        $this->testObject = new $className(...$this->parameters);
    }

    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, $this->testObject);
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getErrors()[0]->getMessage());
        $this->assertSame('type', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame('integer', $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getErrors()[0]->getMessage());
        $this->assertSame('type', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame('double', $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getErrors()[0]->getMessage());
        $this->assertSame('type', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame('boolean', $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getErrors()[0]->getMessage());
        $this->assertSame('type', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame('array', $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getErrors()[0]->getMessage());
        $this->assertSame('type', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame('NULL', $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield $this->testObject->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getErrors()[0]->getMessage());
        $this->assertSame('type', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame('resource', $result->getErrors()[0]->getParameters()[0]->getValue());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getErrors()[0]->getMessage());
        $this->assertSame('type', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame('Closure', $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate('1980-01-01');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getErrors()[0]->getMessage());
        $this->assertSame('type', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame('string', $result->getErrors()[0]->getParameters()[0]->getValue());
    }
}
