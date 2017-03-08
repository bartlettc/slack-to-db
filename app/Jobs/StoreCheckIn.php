<?php

namespace App\Jobs;

use App\createCheckIn;
use App\createCheckInInterface;

class StoreCheckIn extends Job
{

    protected $checkInData;

    /**
     * Create a new job instance.
     *
     * @param createCheckIn|createCheckInInterface $checkInData
     * @internal param createJob $data
     * @internal param $job
     */
    public function __construct(createCheckInInterface $checkInData)
    {
        $this->checkInData = $checkInData;
    }

    /**
     * Execute the job.
     *
     * @internal param createJob $job
     */
    public function handle()
    {
        $this->checkInData->save($this->checkInData);
        return;
    }
}
