<?php

readonly class AuthorDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public ?string $middleName,
    ) {
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            firstName : $data['first_name'] ?? '',
            lastName : $data['last_name'] ?? '',
            middleName : $data['middle_name'] ?? null,
        );
    }
}
