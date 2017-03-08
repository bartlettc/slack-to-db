<?php
/**
 * Created by PhpStorm.
 * User: bartl
 * Date: 25/10/2016
 * Time: 14:39
 */

namespace App;


use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class createCheckOut implements createCheckInInterface
{

    public $checkInData;

    public function __construct($checkInData)
    {
        $this->checkInData = $checkInData;
    }

    public function save($data)
    {
        $details = $data->checkInData;
        $update = DB::update('UPDATE checkins  
                              SET out_time = :out_time 
                              WHERE  team_domain = :team_domain 
                              AND user_id = :user_id 
                              AND command = "/in"
                              AND out_time is null
                              ORDER BY id DESC limit 1',
            [$details['time_set'], $details['team_domain'], $details['user_id']]);
        file_put_contents(storage_path() . '/jobs/o' . microtime(true) . '.txt', var_export([$update, $details], true));

        if (!$update) {
            $this->callbackMessage("Nope, you can't do out before in.", $details['response_url']);
        }

    }

    private function callbackMessage($msgText,$callbackUrl) {
        $payload = json_encode(['text' => $msgText]);
        return (new Client)->post($callbackUrl,['body' => $payload]);
    }
}