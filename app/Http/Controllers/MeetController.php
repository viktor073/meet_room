<?php

namespace App\Http\Controllers;

use App\Interface\Meet\Data\MeetInterface;
use App\Http\Requests\IndexMeetRequest;
use App\Http\Requests\StoreMeetRequest;
use App\Http\Requests\UpdateMeetRequest;
use App\Interface\Meet\MeetRepositoryInterface;
use App\Interface\User\Data\UserInterface;
use App\Models\Meet\Factory\MeetFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MeetController extends Controller
{
    /**
     * @var MeetRepositoryInterface
     */
    private MeetRepositoryInterface $meetRepository;
    /**
     * @var MeetFactory
     */
    private MeetFactory $meetFactory;
    /**
     * @var UserInterface
     */
    private UserInterface $user;

    /**
     * @param MeetRepositoryInterface $meetRepository
     * @param MeetFactory $meetFactory
     * @param UserInterface $user
     */
    public function __construct(
        MeetRepositoryInterface $meetRepository,
        MeetFactory $meetFactory,
        UserInterface $user
    ) {
        $this->meetRepository = $meetRepository;
        $this->meetFactory = $meetFactory;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexMeetRequest $indexMeetRequest
     * @return View
     */
    public function index(IndexMeetRequest $indexMeetRequest): View
    {
        $week = $indexMeetRequest->get('week', 0);
        $meets = $this->meetRepository->getListByWeek($week);
        $dates = $this->getDatesList($week);
        $minutesList = $this->getMinutesList();
        $indexMeets = $this->indexMeetsByDateTime($meets);

        return view(
            'meet.index',
            [
                'meets' => $indexMeets,
                'week' => $week,
                'dates' => $dates,
                'minutes' => $minutesList]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $users = $this->user->all(['id', 'name']);

        return view('meet.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMeetRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreMeetRequest $request): RedirectResponse
    {
        $meet = $this->meetFactory->create($request->toArray());
        try {
            $this->meetRepository->save($meet);
        } catch (\Exception $exception) {
            return redirect()->route('meet.create')->with('error', $exception->getMessage());
        }

        return redirect()->route('meet.show', ['meet' => $meet])->with('status', 'Meet Create!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $meetId
     * @return View
     */
    public function show(int $meetId): View
    {
        try {
            $meet = $this->meetRepository->getById($meetId);
            $message = null;
            $key = 'status';
        }  catch (\Exception $exception) {
            $message = $exception->getMessage();
            $key = 'error';
        }

        return view('meet.show', ['meet' => $meet ?? null])->with($key, $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $meetId
     * @return View
     */
    public function edit(int $meetId): View
    {
        try {
            $meet = $this->meetRepository->getById($meetId);
            $users =  $this->user->all(['id', 'name']);
        }  catch (\Exception $exception) {
            $message = $exception->getMessage();
            $key = 'error';
        }


        return view(
            'meet.update',
            ['meet' => $meet ?? null, 'users' => $users ?? null,]
        )->with($key ?? 'status', $message ?? null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateMeetRequest $request
     * @param int $meetId
     * @return RedirectResponse
     */
    public function update(UpdateMeetRequest $request, int $meetId): RedirectResponse
    {
        try {
            $meet = $this->meetRepository->getById($meetId);
            $meet->addData($request->toArray());
            $this->meetRepository->save($meet);
            $message = 'Meet Updated!';
            $key = 'status';
        } catch (\Exception $exception) {
            return redirect()->route('meet.index')->with('error', $exception->getMessage());
        }

        return redirect()->route('meet.show', ['meet' => $meet])->with($key, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $meetId
     * @return RedirectResponse
     */
    public function destroy(int $meetId): RedirectResponse
    {
        try {
            $this->meetRepository->destroyById($meetId);
        } catch (\Exception $exception) {
            return redirect()->route('meet.index')->with('error', $exception->getMessage());
        }

        return redirect()->route('meet.index')->with('status', 'Meet deleted!');
    }

    /**
     * @param Collection $meets
     * @return array
     */
    protected function indexMeetsByDateTime(Collection $meets): array
    {
        $indexMeets = [];
        /** @var MeetInterface $meet */
        foreach ($meets as $meet) {
            $minutes = 0;
            $dateTime = round(strtotime($meet->getTimeFrom() . ' + ' . $minutes . ' minutes') / 60) * 60;
            $dateTimeTo = strtotime($meet->getTimeTo());
            while ($dateTime <= $dateTimeTo) {
                $indexMeets[$dateTime] = $meet;
                $minutes++;
                $dateTime = round(strtotime($meet->getTimeFrom() . ' + ' . $minutes . ' minutes') / 60) * 60;
            }
        }

        return $indexMeets;
    }

    /**
     * @param $week
     * @return array
     */
    protected function getDatesList($week): array
    {
        $date = strtotime('monday this week ' . 7 * $week . ' days');
        for($i = 0; $i < 7; $i++) {
            $dates[] =  [
                'date' => date("d.m.Y", strtotime('+' . $i . ' day', $date)),
                'name' => __(date("l", strtotime('+' . $i . ' day', $date))),
            ];
        }

        return $dates;
    }

    /**
     * @return array
     */
    protected function getMinutesList(): array
    {
        $midnight = mktime(0,0,0);
        $minutesList = [];
        $min = 0;
        while (count($minutesList) < 1440) {
            $minutesList[] = date('H:i',$midnight + 60 * $min);
            $min++;
        }

        return $minutesList;
    }
}
