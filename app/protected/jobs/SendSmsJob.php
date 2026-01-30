<?php

class SendSmsJob implements JobInterface
{
    /**
     * Отправка SMS уведомления
     *
     * @param array $data ['phone' => string, 'message' => string]
     * @throws SmsException
     */
    public function handle(array $data): void
    {
        $phone = $data['phone'] ?? '';
        $message = $data['message'] ?? '';

        if (empty($phone) || empty($message)) {
            throw new InvalidArgumentException('Phone and message are required');
        }

        Yii::log("Sending SMS to {$phone}: {$message}", CLogger::LEVEL_INFO, 'sms');

        Yii::app()->smsPilot->send($phone, $message);

        Yii::log("SMS sent successfully to {$phone}", CLogger::LEVEL_INFO, 'sms');
    }
}