<?php

namespace Ats\UI\AppBundle\Form\Data;

use Ats\Domain\Project\Model\Project;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectFormData
{
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
     * @var integer|null
     */
    public $vacancies;

    public function __construct()
    {
        $this->startDate = new \DateTime();
        $this->startDate->setTime(0, 0, 0);

        $this->endDate = new \DateTime('+30 days');
        $this->endDate->setTime(0, 0, 0);
    }

    /**
     * @param Project $project
     * @return ProjectFormData
     */
    public static function createFromProject(Project $project)
    {
        $model = new static();
        $model->name = $project->name()->name();
        $model->startDate = $project->duration()->getStart();
        $model->endDate = $project->duration()->getEnd();
        $model->vacancies = $project->vacancies()->vacancies();

        return $model;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());

        $metadata->addPropertyConstraint('name', new Assert\Length(array(
            'min' => 1,
            'max' => 100,
        )));

        $metadata->addPropertyConstraint('startDate', new Assert\NotBlank());
        $metadata->addPropertyConstraint('startDate', new Assert\Date());
        $metadata->addPropertyConstraint('startDate', new Assert\Expression([
            'expression' => 'this.startDate < this.endDate | this.endDate == null'
        ]));

        $metadata->addPropertyConstraint('endDate', new Assert\Date());
        $metadata->addPropertyConstraint('endDate', new Assert\Expression([
            'expression' => 'this.endDate > this.startDate | this.endDate == null'
        ]));

        $metadata->addPropertyConstraint('vacancies', new Assert\Type('integer'));
        $metadata->addPropertyConstraint('vacancies', new Assert\Range([
            'min' => 1,
            'max' => 1000,
        ]));
    }
}