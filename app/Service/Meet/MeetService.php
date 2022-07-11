<?php

namespace App\Service\Meet;

use App\Interface\Meet\MeetRepositoryInterface;

class MeetService
{
    /**
     * @var MeetRepositoryInterface
     */
    private MeetRepositoryInterface $meetRepository;

    /**
     * @param MeetRepositoryInterface $meetRepository
     */
    public function __construct(MeetRepositoryInterface $meetRepository)
    {
        $this->meetRepository = $meetRepository;
    }


}
