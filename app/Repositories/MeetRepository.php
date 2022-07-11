<?php

namespace App\Repositories;

use App\Interface\Meet\Data\MeetInterface;
use App\Interface\Meet\MeetRepositoryInterface;
use App\Models\Meet\Meet;
use Illuminate\Database\Eloquent\Collection;

class MeetRepository implements MeetRepositoryInterface
{
    /**
     * @param int $id
     * @return MeetInterface
     * @throws \Exception
     */
    public function getById(int $id): MeetInterface
    {
        /** @var MeetInterface $meet */
        $meet = Meet::with([MeetInterface::PARTICIPANTS])->findOrFail($id);
        if (!$meet || !$meet->getId()) {
            throw new \Exception(__('The meeting does not exist.'));
        }
        return $meet;
    }

    /**
     * @inheritDoc
     */
    public function getListByWeek(int $week): Collection
    {
        $fromDate = date("Y-m-d", strtotime('monday this week ' . 7 * $week . ' days'));
        $toDate = date("Y-m-d", strtotime('sunday this week ' . 7 * $week . ' days'));

        return Meet::with([MeetInterface::PARTICIPANTS])
            ->where(MeetInterface::TIME_FROM, '>=', $fromDate)
            ->where(MeetInterface::TIME_TO, '<=', $toDate)
            ->get();
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function save(MeetInterface $meet): bool
    {
        try {
            return $meet->store();
        } catch (\Exception $exception) {
            throw new \Exception('Couldn\'t save meeting: ' . $exception->getMessage());
        }
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function destroy(MeetInterface $meet): bool
    {
        try {
            return $meet->remove();
        } catch (\Exception $exception) {
            throw new \Exception('Couldn\'t delete meeting: ' . $exception->getMessage());
        }
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function destroyById(int $id): bool
    {
        $meet = $this->getById($id);
        return $this->destroy($meet);
    }
}
