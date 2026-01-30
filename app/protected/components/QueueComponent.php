<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueComponent extends CApplicationComponent
{
    public string $host;
    public int $port;
    public string $user;
    public string $password;
    public string $queueName = 'sms_notifications';

    private ?AMQPStreamConnection $connection = null;
    private ?\PhpAmqpLib\Channel\AMQPChannel $channel = null;

    private function connect(): void
    {
        if ($this->connection !== null && $this->connection->isConnected()) {
            return;
        }

        $this->connection = new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->user,
            $this->password
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queueName, false, true, false, false);
    }

    /**
     * Добавление задачи в очередь
     */
    public function push(string $jobClass, array $data): void
    {
        $this->connect();

        $payload = json_encode([
            'job' => $jobClass,
            'data' => $data,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $message = new AMQPMessage($payload, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ]);

        $this->channel->basic_publish($message, '', $this->queueName);
    }

    /**
     * Запуск обработки очереди
     */
    public function consume(callable $callback): void
    {
        $this->connect();

        $this->channel->basic_qos(0, 1, false);

        $this->channel->basic_consume(
            $this->queueName,
            '',
            false,
            false,
            false,
            false,
            function ($message) use ($callback) {
                $payload = json_decode($message->body, true);

                try {
                    $callback($payload);
                    $message->ack();
                } catch (Exception $e) {
                    Yii::log("Queue job failed: " . $e->getMessage(), CLogger::LEVEL_ERROR);
                    $message->nack(true); // requeue
                }
            }
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function close(): void
    {
        if ($this->channel !== null) {
            $this->channel->close();
        }
        if ($this->connection !== null && $this->connection->isConnected()) {
            $this->connection->close();
        }
        $this->connection = null;
        $this->channel = null;
    }

    public function __destruct()
    {
        $this->close();
    }
}