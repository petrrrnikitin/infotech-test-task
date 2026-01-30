<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SmsPilotClient extends CApplicationComponent
{
    public string $apiKey;
    public string $apiUrl = 'https://smspilot.ru/api.php';
    public string $sender = 'INFORM';

    private ?Client $httpClient = null;

    private function getHttpClient(): Client
    {
        if ($this->httpClient === null) {
            $this->httpClient = new Client([
                'timeout' => 30,
                'verify' => false,
            ]);
        }

        return $this->httpClient;
    }

    /**
     * Отправка SMS
     *
     * @param string $phone Номер телефона
     * @param string $message Текст сообщения
     * @return array Ответ API
     * @throws SmsException Ошибка отправки
     */
    public function send(string $phone, string $message): array
    {
        $phone = $this->normalizePhone($phone);

        try {
            $response = $this->getHttpClient()->get($this->apiUrl, [
                'query' => [
                    'apikey' => $this->apiKey,
                    'send' => $message,
                    'to' => $phone,
                    'from' => $this->sender,
                    'format' => 'json',
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['error'])) {
                throw new SmsException("SmsPilot error: " . $result['error']['description']);
            }

            Yii::log("SMS sent to {$phone}: {$message}", CLogger::LEVEL_INFO, 'sms');

            return $result;
        } catch (GuzzleException $e) {
            throw new SmsException("HTTP error: " . $e->getMessage());
        }
    }

    /**
     * Нормализация номера телефона
     */
    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '8') && strlen($phone) === 11) {
            $phone = '7' . substr($phone, 1);
        }

        return $phone;
    }
}
