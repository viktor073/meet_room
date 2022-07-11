<?php

namespace App\Models\Meet;

use App\Interface\Meet\Data\MeetInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meet extends Model implements MeetInterface
{
    use HasFactory;

    /**
     * Link Table Users
     */
    const LINK_USERS = 'meets_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::NAME,
        self::DESCRIPTION,
        self::TIME_FROM,
        self::TIME_TO,
        self::PARTICIPANT_IDS,
    ];
    /**
     * @var array
     */
    protected array $relation = [
        self::PARTICIPANTS => self::PARTICIPANT_IDS,
    ];
    /**
     * @var array
     */
    protected array $relationData = [];

    /**
     * @return BelongsToMany
     */
    public function participants(): BelongsToMany
    {
        $this->setAttribute(self::PARTICIPANTS, $this->belongsToMany(User::class, self::LINK_USERS));

        return $this->getAttribute(self::PARTICIPANTS);
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        return $this->getQueueableId();
    }

    /**
     * @inheritDoc
     */
    public function setId(int $id): MeetInterface
    {
        $this->setAttribute(self::ID, $id);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getAttribute(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): MeetInterface
    {
        $this->setAttribute(self::NAME, $name);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->getAttribute(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description): MeetInterface
    {
        $this->setAttribute(self::DESCRIPTION, $description);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTimeFrom(): ?string
    {
        return $this->getAttribute(self::TIME_FROM);
    }

    /**
     * @inheritDoc
     */
    public function setTimeFrom(string $timeFrom): MeetInterface
    {
        $this->setAttribute(self::TIME_FROM, $timeFrom);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTimeTo(): ?string
    {
        return $this->getAttribute(self::TIME_TO);
    }

    /**
     * @inheritDoc
     */
    public function setTimeTo(string $timeTo): MeetInterface
    {
        $this->setAttribute(self::TIME_TO, $timeTo);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getParticipantIds(): ?array
    {
        if (!$this->getAttribute(self::PARTICIPANT_IDS)) {
            $this->setParticipantIds($this->participants()->allRelatedIds()->toArray());
        }

        return $this->getAttribute(self::PARTICIPANT_IDS);
    }

    /**
     * @inheritDoc
     */
    public function setParticipantIds(array $ids): MeetInterface
    {
        $this->setAttribute(self::PARTICIPANT_IDS, $ids);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getParticipants(): ?Collection
    {
        if (!$this->getAttribute(self::PARTICIPANTS)) {
            $this->setParticipants($this->participants()->get());
        }

        return $this->getAttribute(self::PARTICIPANTS);
    }

    /**
     * @inheritDoc
     */
    public function setParticipants(?Collection $participants = null): MeetInterface
    {
        $this->setAttribute(self::PARTICIPANTS, $participants);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getAttribute(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getAttribute(self::UPDATED_AT);
    }

    /**
     * @param array $data
     * @return MeetInterface
     */
    public function addData(array $data): MeetInterface
    {
        foreach ($this->relation as $key => $item) {
            $this->relationData[$key] = $data[$item];
            unset($data[$item]);
        }
        $this->fill($data);

        return $this;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function store(): bool
    {
        $result = $this->save();
        foreach ($this->relationData as $key => $item) {
            $this->$key()->sync($item);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function remove(): bool
    {
        return $this->delete();
    }
}
