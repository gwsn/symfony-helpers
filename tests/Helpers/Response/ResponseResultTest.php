<?php declare(strict_types=1);

namespace UnitTests\GWSN\Helpers\Response;

use GWSN\Helpers\Response\ResponseResult;
use PHPUnit\Framework\TestCase;

class ResponseResultTest extends TestCase
{
    public function testSuccess()
    {
        $responseResult= new ResponseResult();

        $success = true;

        $responseResult->setSuccess($success);

        $this->assertEquals($success, $responseResult->isSuccess());
    }

    public function testError()
    {
        $responseResult= new ResponseResult();

        $error = true;

        $responseResult->setError($error);

        $this->assertEquals($error, $responseResult->isError());
    }

    public function testErrorCode()
    {
        $responseResult= new ResponseResult();

        $errorCode = 500;

        $responseResult->setErrorCode($errorCode);

        $this->assertEquals($errorCode, $responseResult->getErrorCode());
    }

    public function testErrorMessage()
    {
        $responseResult= new ResponseResult();

        $errorMessage = "No product found!";

        $responseResult->setErrorMessage($errorMessage);

        $this->assertEquals($errorMessage, $responseResult->getErrorMessage());
    }

    public function testToArray()
    {
     $responseResultData =   [
            'success' => false,
            'error' => true,
            'errorCode' => 500,
            'errorMessage' => 'No product found!'
        ];

        $responseResult= new ResponseResult();

        $responseResult->setSuccess($responseResultData['success']);
        $responseResult->setError($responseResultData['error']);
        $responseResult->setErrorCode($responseResultData['errorCode']);
        $responseResult->setErrorMessage($responseResultData['errorMessage']);

        $testToArray = $responseResult->toArray();

        $this->assertEquals($responseResultData['success'], $testToArray['success']);
        $this->assertEquals($responseResultData['error'], $testToArray['error']);
        $this->assertEquals($responseResultData['errorCode'], $testToArray['errorCode']);
        $this->assertEquals($responseResultData['errorMessage'], $testToArray['errorMessage']);
    }
}
