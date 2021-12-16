<?php

namespace App\PushNotification;

use Exception;
use GuzzleHttp\Client;

trait PushNotification
{

    public function sendNotification(String $title, String $message)
    {
        try {
            $client = new Client([
                'headers' => [
                    'Authorization' => "key=" . env("FCM_SERVER_KEY"),
                    'Content-Type' => 'application/json',
                ],
            ]);
            $response = $client->post(
                'https://fcm.googleapis.com/fcm/send',
                [
                    'body' => json_encode(
                        [
                            'registration_ids' => [$this->fcmtoken->token],
                            'data' => [
                                'data' => [
                                    'title' => $title,
                                    'message' => $message,
                                    'image' =>  null,
                                    'timestamp' => now()->toDateTimeString(),
                                ],
                            ],
                            "priority" => "high"
                        ]
                    )
                ]
            );
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function sendNotificationTopic(String $title, String $message,$photos = [])
    {
        try {
            $client = new Client([
                'headers' =>
                [
                    'Authorization' => "key=" . env("FCM_SERVER_KEY"),
                    'Content-Type' => 'application/json',
                ],
            ]);
            $response = $client->post(
                'https://fcm.googleapis.com/fcm/send',
                [
                    'body' => json_encode(
                        [
                            'to' => '/topics/mytopic',
                            'data' => [
                                'data' => [
                                    'title' => $title,
                                    'message' => $message,
                                    'image' =>  null,
                                    'timestamp' => now()->toDateTimeString(),
                                    "photos" => $photos
                                ],
                            ],
                            "priority" => "high"
                        ]
                    )
                ]
            );
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
