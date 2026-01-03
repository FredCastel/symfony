<?php

namespace Core\Application\Response;

use Core\Service\Assert\LazyAssertionException;
use Core\Application\Message\ErrorMessage;
use Core\Application\Message\MessageCategory;
use Core\Application\Message\MessageInterface;

class Notification
{
    private array $messages = [];

    public function addMessage(MessageInterface $message): self
    {
        $this->messages[] = $message;

        return $this;
    }

    public function hasError(): bool
    {
        foreach ($this->messages as &$message) {
            if ($message->category() == MessageCategory::Error)
                return true;
        }
        return false;
    }

    /**
     * Summary of getMessages
     * @return MessageInterface[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getErrors(): array
    {
        $mess = [];
        foreach ($this->messages as &$message) {
            if ($message->category() == MessageCategory::Error)
                $mess[] = $message;
        }
        return $mess;
    }
    public function addError(string $code, ...$parameters): ErrorMessage
    {
        $mess = new ErrorMessage($code, "", $parameters);
        $this->addMessage($mess);
        return $mess;
    }

    public function addErrorCode(string $code, ...$parameters): ErrorMessage
    {
        $mess = new ErrorMessage($code, "", $parameters);
        $this->addMessage($mess);
        return $mess;
    }
    public function addErrorMessage(string $message, ...$parameters): ErrorMessage
    {
        $mess = new ErrorMessage(0, $message, $parameters);
        $this->addMessage($mess);
        return $mess;
    }
    public function addAssertionException(LazyAssertionException $ex)
    {
        foreach ($ex->getErrorExceptions() as $error) {
            $mess = new ErrorMessage((string) $error->getCode(), $error->getMessage(), ['property' => $error->getPropertyPath()]);
            $this->addMessage($mess);
        }
    }
    public function getMessage(): string
    {
        return implode(';', $this->messages);
    }
}