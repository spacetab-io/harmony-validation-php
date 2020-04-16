<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Integration\Rule\Isbn;

use Amp\Http\Client\HttpClientBuilder;
use Amp\PHPUnit\AsyncTestCase;
use Amp\Redis\Config;
use Amp\Redis\Redis as RedisClient;
use Amp\Redis\RemoteExecutor;
use Generator;
use HarmonyIO\Cache\Provider\Redis as RedisProvider;
use HarmonyIO\HttpClient\Client\HttpClient;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Isbn\Exists;

class ExistsTest extends AsyncTestCase
{
    /** @var HttpClient */
    private $httpClient;

    public function setUp(): void
    {
        parent::setUp();

        if (!isset($_ENV['BOOKS_API_KEY'])) {
            $this->markTestSkipped('Test skipped because the `BOOKS_API_KEY` google books API key is missing.');
        }

        $client = HttpClientBuilder::buildDefault();
        $redis  = new RedisProvider(new RedisClient(new RemoteExecutor(Config::fromUri('tcp://localhost:6379'))));

        $this->httpClient = new HttpClient($client, $redis);
    }

    public function testValidateFailsWhenIsbnDoesNotExist(): Generator
    {
        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, $_ENV['BOOKS_API_KEY']))->validate('3999215003');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Exists', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenIsbnExists(): Generator
    {
        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, $_ENV['BOOKS_API_KEY']))->validate('9788970137506');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
