<?php

namespace Ats\UI\AppBundle\Controller\Admin;

use Ats\Application\Project\Command\CreateProjectCommand;
use Ats\Application\Project\Command\EditProjectCommand;
use Ats\Application\Project\Command\RemoveProjectCommand;
use Ats\Application\Project\Query\GetAllProjectsQuery;
use Ats\Application\Project\Query\ProjectOfIdQuery;
use Ats\Domain\Project\Exception\ProjectDoesNotExistException;
use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\Repository\ProjectRepository;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\UI\AppBundle\Form\Data\ProjectFormData;
use Ats\UI\AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectController
 *
 * @Route("/admin/project")
 *
 * @package Ats\UI\AppBundle\Controller
 */
class ProjectController extends Controller
{

    /**
     * @Route("/", name="admin_project_index")
     */
    public function indexAction(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $perPage = 10;
        $result = [];

        $this->get('query_bus')->handle(new GetAllProjectsQuery($page, $perPage), $result);

        return $this->render('admin/project/index.html.twig', [
            'vm' => $result
        ]);
    }

    /**
     * @Route("/create", name="admin_project_create")
     */
    public function createAction(Request $request)
    {
        $model = new ProjectFormData();

        $form = $this->createForm(ProjectType::class, $model)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateProjectCommand(
                $this->getProjectRepository()->nextIdentity()->getId(),
                $model->name,
                $model->startDate->format('Y-m-d'),
                $model->endDate ? $model->endDate->format('Y-m-d') : null,
                $model->vacancies
            );

            try {
                $this->get('command_bus')->handle($command);

                $this->addFlash('success', $this->get('translator')->trans('flash.success.created'));

                if ($form->get('saveAndCreateNew')->isClicked()) {
                    return $this->redirectToRoute('admin_project_create');
                }

                return $this->redirectToRoute('admin_project_show', [
                    'id' => $command->id()
                ]);
            } catch (\Exception $ex) {
                $this->get('logger')->error($ex);
                $form->addError(new FormError($this->get('translator')->trans('error.error_occurred')));
            }
        }

        return $this->render('admin/project/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_project_edit")
     */
    public function editAction($id, Request $request)
    {
        $project = $this->findProjectOrFail(new ProjectId($id));

        $model = ProjectFormData::createFromProject($project);

        $form = $this->createForm(ProjectType::class, $model)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new EditProjectCommand(
                $id,
                $model->name,
                $model->startDate->format('Y-m-d'),
                $model->endDate ? $model->endDate->format('Y-m-d') : null,
                $model->vacancies
            );

            try {
                $this->get('command_bus')->handle($command);

                $this->addFlash('success', $this->get('translator')->trans('flash.success.updated'));

                if ($form->get('saveAndCreateNew')->isClicked()) {
                    return $this->redirectToRoute('admin_project_create');
                }

                return $this->redirectToRoute('admin_project_show', [
                    'id' => $command->id()
                ]);
            } catch (\Exception $ex) {
                $this->get('logger')->error($ex);
                $form->addError(new FormError($this->get('translator')->trans('error.error_occurred')));
            }
        }

        return $this->render('admin/project/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="admin_project_show")
     */
    public function showAction($id)
    {
        $project = null;

        $this->get('query_bus')->handle(new ProjectOfIdQuery($id), $project);

        if ($project === null) {
            $this->createNotFoundException();
        }

        return $this->render('admin/project/show.html.twig', [
            'project' => $project
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_project_delete")
     */
    public function deleteAction($id)
    {
        try {
            $this->get('command_bus')->handle(new RemoveProjectCommand($id));

            $this->addFlash('success', $this->get('translator')->trans('flash.success.removed'));
        } catch (ProjectDoesNotExistException $ex) {
            throw $this->createNotFoundException();
        } catch (\Exception $ex) {
            $this->get('logger')->error($ex);
            $this->addFlash('error', $this->get('translator')->trans('error.error_occurred'));
        }

        return $this->redirectToRoute('admin_project_index');
    }

    /**
     * @param ProjectId $id
     * @return Project
     */
    protected function findProjectOrFail(ProjectId $id)
    {
        $project = $this->getProjectRepository()->projectOfId($id);

        if ($project === null) {
            throw $this->createNotFoundException();
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