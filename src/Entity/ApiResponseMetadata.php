<?php declare(strict_types=1);
namespace GWSN\Helpers\Entity;


use Symfony\Component\HttpFoundation\Response;

class ApiResponseMetadata
{
    /**@var int|null $total */
    public ?int $total = null;

    /** @var array $customMetadata */
    public array $customMetadata;

    /** @var ApiSettings $apiSettings */
    public ApiSettings $apiSettings;

    /** @var string $infoMessage */
    public string $infoMessage = 'none';

    /** @var bool $success */
    private bool $success = true;

    /** @var int $errorCode */
    private int $errorCode = 0;

    /** @var string $errorMessage */
    private string $errorMessage = '';


    /**
     * @param array $metadata Define custom metadata or overwrite the metadata keys
     * @param ApiSettings|null $apiSettings
     */
    public function __construct(
        ApiSettings $apiSettings,
        array       $metadata = []
    )
    {
        $this->setCustomMetadata($metadata);
        $this->setApiSettings($apiSettings);
    }

    /**
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * @param int $total
     * @return ApiResponseMetadata
     */
    public function setTotal(int $total): ApiResponseMetadata
    {
        $this->total = $total;
        return $this;
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
     * @return ApiResponseMetadata
     */
    public function setCustomMetadata(array $customMetadata): ApiResponseMetadata
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
     * @return ApiResponseMetadata
     */
    public function setApiSettings(ApiSettings $apiSettings): ApiResponseMetadata
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
     * @return ApiResponseMetadata
     */
    public function setSuccess(bool $success): ApiResponseMetadata
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @return string
     */
    public function getInfoMessage(): string
    {
        return $this->infoMessage;
    }

    /**
     * @param string $infoMessage
     * @return ApiResponseMetadata
     */
    public function setInfoMessage(string $infoMessage): ApiResponseMetadata
    {
        $this->infoMessage = $infoMessage;
        $this->setSuccess(true);

        return $this;
    }

    /**
     * @param string $errorMessage
     * @param int $errorCode
     * @return ApiResponseMetadata
     */
    public function setError(string $errorMessage = '', int $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR): ApiResponseMetadata
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
     * @return ApiResponseMetadata
     */
    public function setErrorCode(int $errorCode): ApiResponseMetadata
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
     * @return ApiResponseMetadata
     */
    public function setErrorMessage(string $errorMessage): ApiResponseMetadata
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
            'auth' => $apiSettings->getApplicationAuthString(),
            'success' => $this->isSuccess(),
            'info' => $this->getInfoMessage(),
            'error' => (! $this->isSuccess() ? [
                'code' => $this->getErrorCode(),
                'message' => $this->getErrorMessage()
            ] : null),
            'total' => $this->getTotal()
        ], $this->getCustomMetadata());
    }
}
