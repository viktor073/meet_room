<?php

namespace App\Models\Meet\Factory;

use App\Interface\Meet\Data\MeetInterface;
use Illuminate\Support\Facades\App;

class MeetFactory
{
    /**
     * @param array $data
     * @return MeetInterface
     */
    public function create(array $data = []): MeetInterface
    {
        /** @var MeetInterface $meet */
        $meet = App::make(MeetInterface::class, $data);
        return $meet->addData($data);
    }
}
