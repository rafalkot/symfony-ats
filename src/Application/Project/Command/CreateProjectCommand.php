<?php

namespace Ats\Application\Project\Command;

class CreateProjectCommand
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $startDate;

    /**
     * @var string|null
     */
    protected $endDate;

    /**
     * @var int|null
     */
    protected $vacancies;

    /**
     * CreateProjectCommand constructor.
     * @param $id
     * @param $name
     * @param $startDate
     * @param $endDate
     * @param $vacancies
     */
    public function __construct($id, $name, $startDate, $endDate, $vacancies)
    {
        $this->id = $id;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->vacancies = $vacancies;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function startDate(): string
    {
        return $this->startDate;
    }

    /**
     * @return null|string
     */
    public function endDate()
    {
        return $this->endDate;
    }

    /**
     * @return int|null
     */
    public function vacancies()
    {
        return $this->vacancies;
    }
}