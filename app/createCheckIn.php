<?php
/**
 * Created by PhpStorm.
 * User: bartl
 * Date: 25/08/2016
 * Time: 17:49
 */

namespace App;

use Illuminate\Support\Facades\DB;

class createCheckIn implements createCheckInInterface
{

    public $checkInData;

    public function __construct($checkInData)
    {
        $this->checkInData = $checkInData;
    }

    public function save($data)
    {
        $details = $data->checkInData;
        DB::insert('INSERT INTO checkins (team_id,team_domain,channel_id,channel_name,user_id,user_name,command,text,response_url,time_set,source)
                    VALUES(:team_id,:team_domain,:channel_id,:channel_name,:user_id,:user_name,:command,:text,:response_url,:time_set,:source)',
            [$details['team_id'], $details['team_domain'], $details['channel_id'], $details['channel_name'], $details['user_id']
                , $details['user_name'], $details['command'], $details['text'], $details['response_url'], $details['time_set'], $details['source']]);
        file_put_contents(storage_path() . '/jobs/i' . microtime(true) . '.txt', var_export($details, true));
    }
}