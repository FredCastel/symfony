<?php

namespace Core\Application\Message;

class Message implements MessageInterface
{
    protected MessageCategory $category;
    protected ?array $parameters;
    protected ?string $message;
    protected string $code = "0";

    public function __construct(MessageCategory $category, string $code, ?string $message, array $parameters)
    {
        $this->category = $category;
        $this->parameters = $parameters;
        $this->message = $message;
        $this->code = $code;
    }

    public function __toString(): string
    {
        return msgfmt_format_message('en_US', $this->message, $this->parameters);
    }

    public function category(): MessageCategory
    {
        return $this->category;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function message(): ?string
    {
        return $this->message;
    }
    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }
}