<?php

namespace Core\Infrastructure\ApiPlatform\Exception;

use ApiPlatform\Metadata\ErrorResource;
use ApiPlatform\Metadata\Exception\ProblemExceptionInterface;
use Core\Application\Message\Message;
use Core\Application\Response\NotificationExceptionInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ErrorResource()]
class ApiCommandValidatorException extends \Exception implements ProblemExceptionInterface
{
    public function __construct(
        private NotificationExceptionInterface $notificationException
    ) {
        parent::__construct($this->notificationException->getNotification()->getMessage(), 422, $this->notificationException);

    }
    public function getType(): string
    {
        return 'error';
    }
    public function getTitle(): ?string
    {
        return 'Application Error';
    }
    public function getStatus(): ?int
    {
        return 422;
    }
    public function getDetail(): ?string
    {
        return $this->notificationException->getNotification()->getMessage();
    }
    public function getInstance(): ?string
    {
        return null;
    }
}