<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Integration\Rule\Network\Url;

use Amp\Http\Client\HttpClientBuilder;
use Amp\PHPUnit\AsyncTestCase;
use Amp\Redis\Config;
use Amp\Redis\Redis as RedisClient;
use Amp\Redis\RemoteExecutor;
use Generator;
use HarmonyIO\Cache\Provider\Redis as RedisProvider;
use HarmonyIO\HttpClient\Client\HttpClient;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\Url\OkResponse;

class OkResponseTest extends AsyncTestCase
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

    public function testValidateFailsOnNotFoundResponse(): Generator
    {
        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('http://google.com/dlksjksjfkhdsfjk');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.OkResponse', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsOnNonExistingDomain(): Generator
    {
        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('http://dkhj3kry43iufhr3e.example.com');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.OkResponse', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenResponseHasErrorStatusCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('https://httpbin.org/status/500');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.OkResponse', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsOnRedirectedOkResponse(): Generator
    {
        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('http://google.com');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsOnOkResponse(): Generator
    {
        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('https://google.com');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsOnOkResponseWithPath(): Generator
    {
        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('https://google.com/imghp');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
