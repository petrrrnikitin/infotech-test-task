<?php

class WorkerCommand extends CConsoleCommand
{
    public function getHelp(): string
    {
        return <<<EOD
USAGE
  yiic worker run

DESCRIPTION
  Запускает обработчик очереди сообщений.
  Обрабатывает задачи из RabbitMQ и выполняет их.

EOD;
    }

    /**
     * Запуск обработчика очереди
     */
    public function actionRun(): void
    {
        echo "Starting queue worker...\n";
        echo "Waiting for messages. Press Ctrl+C to exit.\n\n";

        Yii::app()->queue->consume(function (array $payload) {
            $jobClass = $payload['job'] ?? null;
            $data = $payload['data'] ?? [];
            $createdAt = $payload['created_at'] ?? 'unknown';

            echo "[" . date('Y-m-d H:i:s') . "] Processing job: {$jobClass} (created: {$createdAt})\n";

            if (!$jobClass) {
                echo "  ERROR: Job class not specified\n";
                return;
            }

            if (!class_exists($jobClass)) {
                echo "  ERROR: Job class {$jobClass} not found\n";
                return;
            }

            $job = new $jobClass();

            if (!$job instanceof JobInterface) {
                echo "  ERROR: {$jobClass} must implement JobInterface\n";
                return;
            }

            try {
                $job->handle($data);
                echo "  SUCCESS: Job completed\n";
            } catch (Exception $e) {
                echo "  ERROR: " . $e->getMessage() . "\n";
                throw $e; // Requeue the message
            }
        });
    }
}
