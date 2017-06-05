<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\ValueObject;

use Ats\Domain\Ad\Exception\AdPublicationEndDateIsEarlierThanStartDate;

class AdPublication
{
    /**
     * @var \DateTimeImmutable
     */
    private $start;

    /**
     * @var \DateTimeImmutable|null
     */
    private $end;

    /**
     * AdPublication constructor.
     * @param \DateTimeImmutable $start
     * @param \DateTimeImmutable|null $end
     */
    public function __construct(\DateTimeImmutable $start, \DateTimeImmutable $end = null)
    {
        $this->start = $start->setTime(0, 0, 0);
        $this->setEnd($end);
    }

    /**
     * @param string $start
     * @param string|null $end
     * @return AdPublication
     */
    public static function fromString($start, $end = null)
    {
        $start = \DateTimeImmutable::createFromFormat('Y-m-d', $start);
        $end = $end ? \DateTimeImmutable::createFromFormat('Y-m-d', $end) : null;

        return new self($start, $end);
    }

    /**
     * @param \DateTimeImmutable|null $end
     */
    private function setEnd(\DateTimeImmutable $end = null)
    {
        if ($end instanceof \DateTimeImmutable) {
            $end = $end->setTime(0, 0, 0);
        }

        if ($end instanceof \DateTimeImmutable && $end <= $this->start) {
            throw new AdPublicationEndDateIsEarlierThanStartDate();
        }

        $this->end = $end;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function start(): \DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function end()
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
     * @param AdPublication $publication
     * @return bool
     */
    public function equals(AdPublication $publication): bool
    {
        return $this->start->format('Y-m-d') === $publication->start()->format('Y-m-d') && (
            $this->hasEnd() ? $this->end->format('Y-m-d') == $publication->end()->format('Y-m-d') :
                $this->end === $publication->end()
            );
    }
}