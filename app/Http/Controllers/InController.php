<?php

namespace App\Http\Controllers;

use App\createCheckIn;
use App\Jobs\StoreCheckIn;
use App\Traits\validateSlackToken;
use Illuminate\Http\Request;


class InController extends Controller
{


    use validateSlackToken;
    private $token = env('SLACK_API_KEY');

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        if (!$this->checkToken($this->token, $request->input())) {
            return "Somethings not quite right";
        }
        $this->addToQueue($request->input());
        return "Got ya!";
    }


    /**
     * @param array $slashCommand
     * @internal param array $job
     */
    private function addToQueue(array $slashCommand)
    {
        $slashCommand['source'] = 'slack';
        $utc = new \DateTime('now', new \DateTimeZone('UTC'));
        $slashCommand['time_set'] = $utc->format('Y-m-d H:i:s');
        //Create object with data stored on it
        $created = new createCheckIn($slashCommand);
        //Place that on the q
        $this->dispatch(new StoreCheckIn($created));
    }


}

