<?php

class FileUploader extends CApplicationComponent
{
    public string $baseUploadPath;
    public int $maxFileSize;
    /** @var string[] */
    public array $allowedExtensions;
    /** @var string[] */
    public array $allowedMimeTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
    ];

    /**
     * Загрузка файла
     *
     * @param CUploadedFile|null $file Загруженный файл
     * @param string $directory Директория для сохранения
     * @param string $prefix Префикс имени файла
     * @return string Путь к файлу относительно uploads/
     * @throws FileUploadException Ошибка загрузки
     */
    public function upload(?CUploadedFile $file, string $directory, string $prefix = ''): string
    {
        if (!$file) {
            throw new FileUploadException('Файл не загружен');
        }

        $extension = strtolower($file->getExtensionName());
        if (!in_array($extension, $this->allowedExtensions, true)) {
            throw new FileUploadException(
                'Недопустимый тип файла. Разрешены: ' . implode(', ', $this->allowedExtensions)
            );
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file->getTempName());
        finfo_close($finfo);

        $expectedMime = $this->allowedMimeTypes[$extension] ?? null;
        if ($expectedMime === null || $mimeType !== $expectedMime) {
            throw new FileUploadException('Недопустимый MIME-тип файла');
        }

        if ($file->getSize() > $this->maxFileSize) {
            throw new FileUploadException(
                'Файл слишком большой. Максимальный размер: ' . ($this->maxFileSize / 1024 / 1024) . ' MB'
            );
        }

        $uploadDir = $this->baseUploadPath . '/' . $directory;
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploadDir));
            }
        }

        $filename = ($prefix ? $prefix . '_' : '') . time() . '_' . uniqid('', true) . '.' . $extension;
        $fullPath = $uploadDir . '/' . $filename;

        if (!$file->saveAs($fullPath)) {
            throw new FileUploadException('Не удалось сохранить файл');
        }

        return $directory . '/' . $filename;
    }

    /**
     * Удаление файла
     *
     * @param string|null $filePath Путь к файлу
     * @return bool Успешность операции
     * @throws FileDeleteException Ошибка удаления
     */
    public function delete(?string $filePath): bool
    {
        if (!$filePath) {
            return true;
        }

        $fullPath = $this->baseUploadPath . '/' . $filePath;
        if (file_exists($fullPath)) {
            if (!unlink($fullPath)) {
                throw new FileDeleteException('Не удалось удалить файл');
            }
        }

        return true;
    }

}
