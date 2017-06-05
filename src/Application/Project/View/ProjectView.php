<?php

declare(strict_types=1);

namespace Ats\Application\Project\View;

use Ats\Application\Core\View\AbstractView;

class ProjectView extends AbstractView
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var \DateTime
     */
    public $startDate;

    /**
     * @var \DateTime|null
     */
    public $endDate;

    /**
     * @var int|null
     */
    public $vacancies;

    /**
     * ProjectViewModel constructor.
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

        parent::__construct([]);
    }
}