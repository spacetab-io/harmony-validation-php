<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;

class NumericTestCase extends AsyncTestCase
{
    /** @var string */
    protected $classUnderTest;

    /** @var array<mixed> */
    protected $parameters = [];

    /** @var Rule */
    protected $testObject;

    /**
     * NumericTestCase constructor.
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

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.NumericType', $result->getErrors()[0]->getMessage());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.NumericType', $result->getErrors()[0]->getMessage());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.NumericType', $result->getErrors()[0]->getMessage());
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
        $this->assertSame('Numeric.NumericType', $result->getErrors()[0]->getMessage());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.NumericType', $result->getErrors()[0]->getMessage());
    }

    public function testValidateFailsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.NumericType', $result->getErrors()[0]->getMessage());
    }

    public function testValidateFailsWhenPassingANonNumericString(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate('non numeric');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.NumericType', $result->getErrors()[0]->getMessage());
    }
}
