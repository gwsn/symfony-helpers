<?php declare(strict_types=1);

namespace UnitTests\GWSN\Helpers\Response;

use GWSN\Helpers\Response\ApiResponse;
use GWSN\Helpers\Response\ResponseResult;
use PHPUnit\Framework\TestCase;

class ApiResponseTest extends TestCase
{

    /**
     * @var array
     */
    private array $metadataDefaults;

    /**
     * @var ResponseResult
     */
    private ResponseResult $responseResult;

    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var array
     */
    private array $dataArray;

    public function setUp():void {
        $this->responseResult = new ResponseResult();

        $this->statusCode = 200;

        $this->metadataDefaults = [
            'version' => '1.0.0',
            'api' => 'Batch System API',
            'auth' => 'V1',
            'success' => true,
            'error' =>  null,
        ];

        $this->dataArray = [
          'data' => null,
          'meta' => [],
          'status' => 200
        ];

    }

    public function testDefaults()
    {

        $response = new ApiResponse([], $this->responseResult, $this->statusCode);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($this->statusCode, $response->getStatusCode());
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('meta', $responseData);
        $this->assertArrayHasKey('status', $responseData);

        $this->assertEquals($this->statusCode, $responseData['status']);
        $this->assertEquals($this->metadataDefaults['version'], $responseData['meta']['version']);
        $this->assertEquals($this->metadataDefaults['api'], $responseData['meta']['api']);
        $this->assertEquals($this->metadataDefaults['auth'], $responseData['meta']['auth']);
        $this->assertTrue($responseData['meta']['success']);
        $this->assertNull($responseData['meta']['error']);
    }

    public function testWithError()
    {
        $this->statusCode = 500;
        $this->responseResult->setErrorCode($this->statusCode);
        $this->responseResult->setErrorMessage("This is a error");
        $response = new ApiResponse([], $this->responseResult, $this->statusCode);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($this->statusCode, $response->getStatusCode());
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('meta', $responseData);
        $this->assertArrayHasKey('status', $responseData);

        $this->assertEquals($this->statusCode, $responseData['status']);
        $this->assertEquals($this->metadataDefaults['version'], $responseData['meta']['version']);
        $this->assertEquals($this->metadataDefaults['api'], $responseData['meta']['api']);
        $this->assertEquals($this->metadataDefaults['auth'], $responseData['meta']['auth']);
        $this->assertFalse($responseData['meta']['success']);
        $this->assertIsArray($responseData['meta']['error']);

        $this->assertArrayHasKey('code', $responseData['meta']['error']);
        $this->assertArrayHasKey('message', $responseData['meta']['error']);
        $responseError = $responseData['meta']['error'];

        $this->assertEquals($this->responseResult->getErrorCode(), $responseError['code']);
        $this->assertEquals($this->responseResult->getErrorMessage(), $responseError['message']);
    }

    public function testMetadataOverwrite()
    {
        //Version
        $metadataVersion = ['version' => '2.0.0'];
        $response = new ApiResponse([], $this->responseResult, $this->statusCode, [], $metadataVersion);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($this->statusCode, $response->getStatusCode());

        $this->assertEquals($metadataVersion['version'], $responseData['meta']['version']);
        $this->assertEquals($this->metadataDefaults['api'], $responseData['meta']['api']);
        $this->assertEquals($this->metadataDefaults['auth'], $responseData['meta']['auth']);

        //API
        $metadataApi = ['api' => 'Spill System'];
        $response = new ApiResponse([], $this->responseResult, $this->statusCode, [], $metadataApi);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($this->statusCode, $response->getStatusCode());

        $this->assertEquals($this->metadataDefaults['version'], $responseData['meta']['version']);
        $this->assertEquals($metadataApi['api'], $responseData['meta']['api']);
        $this->assertEquals($this->metadataDefaults['auth'], $responseData['meta']['auth']);

        //Auth
        $metadataAuth = ['auth' => 'V2'];
        $response = new ApiResponse([], $this->responseResult, $this->statusCode, [], $metadataAuth);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($this->statusCode, $response->getStatusCode());

        $this->assertEquals($this->metadataDefaults['version'], $responseData['meta']['version']);
        $this->assertEquals($this->metadataDefaults['api'], $responseData['meta']['api']);
        $this->assertEquals($metadataAuth['auth'], $responseData['meta']['auth']);

    }

    public function testCustomHeader()
    {
        $headers = [
            "x-henky" => 'test',
        ];
        $response = new ApiResponse([], $this->responseResult, $this->statusCode, $headers);

        $this->assertEquals($headers['x-henky'], $response->headers->get("x-henky"));
        $this->assertEquals('application/json', $response->headers->get("content-type"));
    }

    public function testData()
    {
        $data = $this->dataArray['data'] = 'turtle';
        $response = new ApiResponse($data, $this->responseResult, $this->statusCode);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($this->dataArray['data'], $responseData['data']);
    }

    public function testStatus()
    {
        $data = $this->dataArray['status'] = 200;
        $response = new ApiResponse($data, $this->responseResult, $this->statusCode);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals($this->dataArray['status'], $responseData['status']);
    }


}
