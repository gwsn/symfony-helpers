<?php declare(strict_types=1);
namespace GWSN\Helpers\Entity;


use Symfony\Component\HttpFoundation\Response;

class ResponseMetadata
{
    public array $customMetadata;
    public ApiSettings $apiSettings;

    public string $message = '';
    private bool $success = true;
    private int $errorCode = 0;
    private string $errorMessage = '';


    /**
     * @param array $metadata Define custom metadata or overwrite the metadata keys
     * @param ApiSettings|null $apiSettings
     */
    public function __construct(
        array       $metadata = [],
        ApiSettings $apiSettings = null
    )
    {
        $this->setCustomMetadata($metadata);
        $this->setApiSettings(($apiSettings ?? $this->apiSettings = new ApiSettings(null)));
    }

    /**
     * @return array
     */
    public function getCustomMetadata(): array
    {
        return $this->customMetadata;
    }

    /**
     * @param array $customMetadata
     * @return ResponseMetadata
     */
    public function setCustomMetadata(array $customMetadata): ResponseMetadata
    {
        $this->customMetadata = $customMetadata;
        return $this;
    }

    /**
     * @return ApiSettings
     */
    public function getApiSettings(): ApiSettings
    {
        return $this->apiSettings;
    }

    /**
     * @param ApiSettings $apiSettings
     * @return ResponseMetadata
     */
    public function setApiSettings(ApiSettings $apiSettings): ResponseMetadata
    {
        $this->apiSettings = $apiSettings;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     * @return ResponseMetadata
     */
    public function setSuccess(bool $success): ResponseMetadata
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ResponseMetadata
     */
    public function setMessage(string $message): ResponseMetadata
    {
        $this->message = $message;
        $this->setSuccess(true);

        return $this;
    }

    /**
     * @param string $errorMessage
     * @param int $errorCode
     * @return ResponseMetadata
     */
    public function setError(string $errorMessage = '', int $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR): ResponseMetadata
    {
        $this->setSuccess(false);
        $this->setErrorMessage($errorMessage);
        $this->setErrorCode($errorCode);
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
     * @return ResponseMetadata
     */
    public function setErrorCode(int $errorCode): ResponseMetadata
    {
        $this->errorCode = $errorCode;
        if ($this->isSuccess()) {
            $this->setSuccess(false);
        }
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
     * @return ResponseMetadata
     */
    public function setErrorMessage(string $errorMessage): ResponseMetadata
    {
        $this->errorMessage = $errorMessage;
        if ($this->isSuccess()) {
            $this->setSuccess(false);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $apiSettings = $this->getApiSettings();
        
        return array_merge([
            'version' => $apiSettings->getApplicationVersion(),
            'api' => $apiSettings->getApplicationName(),
            'auth' => $apiSettings->getApplicationAuthVersion(),
            'success' => $this->isSuccess(),
            'error' => (! $this->isSuccess() ? [
                'code' => $this->getErrorCode(),
                'message' => $this->getErrorMessage()
            ] : null),
        ], $this->getCustomMetadata());
    }
}
