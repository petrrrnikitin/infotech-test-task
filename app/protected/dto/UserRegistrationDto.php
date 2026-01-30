<?php


readonly class UserRegistrationDto
{
    public function __construct(
        public string $username,
        public string $email,
        public string $password,
    ) {
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            username : $data['username'] ?? '',
            email : $data['email'] ?? '',
            password : $data['password'] ?? '',
        );
    }
}
