<?php

namespace App\Services;

use CS_REST_Subscribers;
use CS_REST_Transactional_SmartEmail;
use CS_REST_Transactional_SmartEmail_Send;

class CampaignMonitorService
{
    protected $listId;
    protected $auth;

    public function __construct()
    {
        $this->listId = env('CAMPAIGN_MONITOR_LIST_ID');
        $this->auth = ['api_key' => env('CAMPAIGN_MONITOR_API_KEY')];
    }

    public function addSubscriber(string $email, string $name)
    {
        $wrap = new CS_REST_Subscribers($this->listId, $this->auth);
        return $wrap->add([
            'EmailAddress' => $email,
            'Name' => $name,
            'Resubscribe' => true
        ]);
    }

   public function sendEmail(array $data)
{
    try {
        $apiKey = env('CAMPAIGN_MONITOR_API_KEY');
        $fromEmail = env('MAIL_FROM_ADDRESS', 'no-reply@example.com');
        $fromName = env('MAIL_FROM_NAME', 'E-Commerce Store');

        $payload = [
            'From' => "{$fromName} <{$fromEmail}>",
            'To' => $data['email'],
            'Subject' => $data['subject'],
            'Html' => $data['html']
        ];

        $ch = curl_init('https://api.createsend.com/api/v3.3/transactional/smartemail/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode($apiKey . ':x'),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status >= 200 && $status < 300) {
            return ['success' => true, 'response' => json_decode($response, true)];
        }

        return ['success' => false, 'error' => $response];
    } catch (\Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
  }
}
