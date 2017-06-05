<?php

declare(strict_types=1);

namespace Ats\Domain\Project\ValueObject;

use Ats\Domain\Project\Exception\ProjectVacanciesInvalidValue;

class ProjectVacancies
{
    const MIN_VACANCIES = 1;

    const MAX_VACANCIES = 1000;

    /**
     * @var int|null
     */
    private $vacancies;

    /**
     * @param int|null $vacancies
     */
    public function __construct(int $vacancies = null)
    {
        $this->validate($vacancies);

        $this->vacancies = $vacancies;
    }

    public function vacancies()
    {
        return $this->vacancies;
    }

    public function __toString()
    {
        return (string)$this->vacancies;
    }

    /**
     * @param ProjectVacancies $vacancies
     * @return bool
     */
    public function equals(ProjectVacancies $vacancies): bool
    {
        return $this->vacancies === $vacancies->vacancies();
    }

    protected function validate($value)
    {
        if ($value === null) {
            return;
        }

        if (!is_int($value) || $value < self::MIN_VACANCIES || $value > self::MAX_VACANCIES) {
            throw new ProjectVacanciesInvalidValue();
        }
    }
}