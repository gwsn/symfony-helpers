<?php declare(strict_types=1);

namespace GWSN\Helpers\Response;

class ResponseResult
{
    /**
     * @var bool
     */
    private bool $success = true;

    /**
     * @var bool
     */
    private bool $error = false;

    /**
     * @var int
     */
    private int $errorCode = 0;

    /**
     * @var string
     */
    private string $errorMessage = '';

    //Getters and Setters
    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     * @return ResponseResult
     */
    public function setSuccess(bool $success): ResponseResult
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     * @return ResponseResult
     */
    public function setError(bool $error): ResponseResult
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     * @return ResponseResult
     */
    public function setErrorCode(int $errorCode): ResponseResult
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     * @return ResponseResult
     */
    public function setErrorMessage(string $errorMessage): ResponseResult
    {
        $this->setError(true);
        $this->setSuccess(false);
        $this->errorMessage = $errorMessage;
        return $this;
    }
    //End of Getters and Setters

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        return [
            'success' => $this->isSuccess(),
            'error' => $this->isError(),
            'errorCode' => $this->getErrorCode(),
            'errorMessage' => $this->getErrorMessage(),
        ];
    }

}
