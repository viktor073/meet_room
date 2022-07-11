<?php

namespace App\Interface\Meet;

use App\Interface\Meet\Data\MeetInterface;
use App\Models\Meet\Meet;
use Illuminate\Database\Eloquent\Collection;

interface MeetRepositoryInterface
{
    /**
     * @param int $id
     * @return MeetInterface
     */
    public function getById(int $id): MeetInterface;

    /**
     * @param int $week
     * @return Collection
     */
    public function getListByWeek(int $week): Collection;

    /**
     * @param MeetInterface $meet
     * @return bool
     */
    public function save(MeetInterface $meet): bool;

    /**
     * @param MeetInterface $meet
     * @return bool
     */
    public function destroy(MeetInterface $meet): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function destroyById(int $id): bool;
}
