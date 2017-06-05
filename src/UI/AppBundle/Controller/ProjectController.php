<?php

namespace Ats\UI\AppBundle\Controller;

use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\Repository\ProjectRepository;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectId;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ProjectController
 *
 * @Route("/project")
 *
 * @package Ats\UI\AppBundle\Controller
 */
class ProjectController extends Controller
{

    /**
     * @Route("/", name="project_index")
     */
    public function indexAction()
    {
        $projectRepository = $this->get('project_repository');
        /* @var $projectRepository ProjectRepository */
        var_dump($projectRepository->size());
        var_dump($projectRepository->projectOfId(new ProjectId(1)));
        //var_dump($projectRepository->save(new Project(new ProjectId(123), 'nazwa projektu',
        //    new ProjectDuration(new \DateTimeImmutable()), 2)));

        return $this->render('project/index.html.twig', [
            'projects' =>
                $projectRepository->all()
        ]);
    }

    /**
     * @param $id
     * @Route("/{id}", name="project_view")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id)
    {
        return $this->render('project/view.html.twig', [
            'project' =>
                $this->findProjectOrFail(new ProjectId($id))
        ]);
    }

    /**
     * @param ProjectId $id
     * @return Project
     */
    protected function findProjectOrFail(ProjectId $id)
    {
        $project = $this->getProjectRepository()->projectOfId($id);

        if ($project === null) {
            $this->createNotFoundException();
        }

        return $project;
    }

    /**
     * @return ProjectRepository
     */
    protected function getProjectRepository(): ProjectRepository
    {
        return $this->get('project_repository');
    }
}