<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Integration\Rule\Network\Domain;

use Amp\Http\Client\HttpClientBuilder;
use Amp\PHPUnit\AsyncTestCase;
use Amp\Redis\Config;
use Amp\Redis\Redis as RedisClient;
use Amp\Redis\RemoteExecutor;
use Generator;
use HarmonyIO\Cache\Provider\Redis as RedisProvider;
use HarmonyIO\HttpClient\Client\HttpClient;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\Domain\Tld;

class TldTest extends AsyncTestCase
{
    /** @var HttpClient */
    private $httpClient;

    public function setUp(): void
    {
        parent::setUp();

        $client = HttpClientBuilder::buildDefault();
        $redis  = new RedisProvider(new RedisClient(new RemoteExecutor(Config::fromUri('tcp://localhost:6379'))));

        $this->httpClient = new HttpClient($client, $redis);
    }

    /**
     * @dataProvider provideInvalidTlds
     */
    public function testNonExistingYouTubeIdsToReturnFalse(string $tld): Generator
    {
        /** @var Result $result */
        $result = yield (new Tld($this->httpClient))->validate($tld);

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Domain.Tld', $result->getFirstError()->getMessage());
    }

    /**
     * @dataProvider provideValidTlds
     */
    public function testValidYouTubeIdsToReturnTrue(string $tld): Generator
    {
        /** @var Result $result */
        $result = yield (new Tld($this->httpClient))->validate($tld);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    /**
     * @return array<array<string>>
     */
    public function provideInvalidTlds(): array
    {
        return [
            ['SHIRLEYTHISWILLNEVERBEAVALIDTLDRIGHTRIIITE'],
        ];
    }

    /**
     * @return array<array<string>>
     */
    public function provideValidTlds(): array
    {
        return [
            ['YOUTUBE'],
            ['youtube'],
            ['XN--TIQ49XQYJ'],
            ['xn--tiq49xqyj'],
        ];
    }
}
