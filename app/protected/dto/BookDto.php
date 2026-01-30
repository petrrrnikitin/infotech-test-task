<?php

readonly class BookDto
{
    public function __construct(
        public string $title,
        public int $year,
        public string $isbn,
        public ?string $description,
        public ?CUploadedFile $photo,
        public array $authorIds,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            title: $data['title'] ?? '',
            year: (int)($data['year'] ?? 0),
            isbn: $data['isbn'] ?? '',
            description: $data['description'] ?? null,
            photo: CUploadedFile::getInstanceByName('Book[photo]'),
            authorIds: $data['authorIds'] ?? [],
        );
    }
}
