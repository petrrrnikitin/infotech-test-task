<?php

class ValidationException extends BaseException
{
    private array $errors;

    /**
     * @param array $errors массив ошибок валидации
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct($this->formatErrors());
    }

    private function formatErrors(): string
    {
        $messages = array();
        foreach ($this->errors as $errors) {
            $messages[] = implode(', ', $errors);
        }
        return implode('; ', $messages);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
