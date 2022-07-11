<?php

namespace App\Interface\Meet\Data;

use Illuminate\Database\Eloquent\Collection;

interface MeetInterface
{
    /**
     * Fields
     */
    const ID = 'id';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const TIME_FROM = 'time_from';
    const TIME_TO = 'time_to';
    const PARTICIPANTS = 'participants';
    const PARTICIPANT_IDS = 'participant_ids';

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self;

    /**
     * @return string|null
     */
    public function getTimeFrom(): ?string;

    /**
     * @param string $timeFrom
     * @return $this
     */
    public function setTimeFrom(string $timeFrom): self;

    /**
     * @return string|null
     */
    public function getTimeTo(): ?string;

    /**
     * @param string $timeTo
     * @return $this
     */
    public function setTimeTo(string $timeTo): self;

    /**
     * @return array|null
     */
    public function getParticipantIds(): ?array;

    /**
     * @param array $ids
     * @return $this
     */
    public function setParticipantIds(array $ids): self;

    /**
     * @return Collection|null
     */
    public function getParticipants(): ?Collection;

    /**
     * @param Collection $participants
     * @return $this
     */
    public function setParticipants(Collection $participants): self;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param array $data
     * @return $this
     */
    public function addData(array $data): self;

    /**
     * @return bool
     */
    public function store(): bool;

    /**
     * @return bool
     */
    public function remove(): bool;
}
