<?php

declare(strict_types=1);

namespace Ats\Domain\Project\ValueObject;

class ProjectDuration
{
    /**
     * @var \DateTimeImmutable
     */
    private $start;

    /**
     * @var \DateTimeImmutable
     */
    private $end;

    public function __construct(\DateTimeImmutable $start, \DateTimeImmutable $end = null)
    {
        $this->start = $start->setTime(0, 0, 0);
        $this->setEnd($end);
    }

    /**
     * @param string $start
     * @param string|null $end
     * @return ProjectDuration
     */
    public static function fromString($start, $end = null)
    {
        $start = \DateTimeImmutable::createFromFormat('Y-m-d', $start);
        $end = $end ? \DateTimeImmutable::createFromFormat('Y-m-d', $end) : null;

        return new self($start, $end);
    }

    private function setEnd(\DateTimeImmutable $end = null)
    {
        if ($end instanceof \DateTimeImmutable) {
            $end = $end->setTime(0, 0, 0);
        }

        if ($end instanceof \DateTimeImmutable && $end <= $this->start) {
            throw new \InvalidArgumentException('Project end date must be greater than start date');
        }

        $this->end = $end;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return bool
     */
    public function hasEnd(): bool
    {
        return $this->end !== null;
    }

    /**
     * @param ProjectDuration $duration
     * @return bool
     */
    public function equals(ProjectDuration $duration): bool
    {
        return $this->start->format('Y-m-d') === $duration->getStart()->format('Y-m-d') && (
            $this->hasEnd() ? $this->end->format('Y-m-d') == $duration->getEnd()->format('Y-m-d') :
                $this->end === $duration->end
            );
    }
}