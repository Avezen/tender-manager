<?php

namespace App\Controller;

use App\Constants\FlashMessages;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Manager\ProjectManager;
use App\RequestData\ProjectData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project/list", name="project_list")
     * @param ProjectManager $projectManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProjects(ProjectManager $projectManager)
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository(Project::class)->findAll();

        return $this->render('project/list.html.twig', [
            'projects' => $projectManager->prepareListForResponse($projects),
        ]);
    }

    /**
     * @Route("/project/{id}/view", name="project_view")
     * @param $id
     * @param ProjectManager $projectManager
     * @param Project|null $project
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProject($id, ProjectManager $projectManager, Project $project = null)
    {
        if (!$project) {
            return new JsonResponse(
                new EntityNotFoundMyException('Project with id: ' . $id . ' does not exist', 404)
            );
        }

        return $this->render('project/view.html.twig', [
            'project' => $projectManager->prepareForResponse($project),
        ]);
    }


    /**
     * @Route("/project/create", name="project_create")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createProject(Request $request, ProjectManager $projectManager)
    {
        $createProjectData = new ProjectData();

        $form = $this->createForm(ProjectType::class, $createProjectData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project = $projectManager->create($form->getData());

            $this->addFlash('success', FlashMessages::PROJECT_CREATE_SUCCESS);
            return $this->redirectToRoute('project_view', [
                'id' => $project->getId()
            ]);
        }

        return $this->render('project/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/{id}/edit", name="project_edit")
     * @param $id
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param Project|null $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editProject($id, Request $request, ProjectManager $projectManager, Project $project = null)
    {
        if (!$project) {
            return new JsonResponse(
                new EntityNotFoundMyException('Project with id: ' . $id . ' does not exist', 404)
            );
        }

        $editProjectData = ProjectData::fromProject($project);

        $form = $this->createForm(ProjectType::class, $editProjectData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project = $projectManager->update($project, $form->getData());

            $this->addFlash('success', FlashMessages::PROJECT_UPDATE_SUCCESS);
            return $this->redirectToRoute('project_view', [
                'id' => $project->getId()
            ]);
        }

        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project
        ]);
    }

    /**
     * @Route("/project/{id}/delete", name="project_delete")
     * @param $id
     * @param ProjectManager $projectManager
     * @param Project|null $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteProject($id, ProjectManager $projectManager, Project $project = null)
    {
        if (!$project) {
            return new JsonResponse(
                new EntityNotFoundMyException('Project with id: ' . $id . ' does not exist', 404)
            );
        }

        $projectManager->delete($project);
        $this->addFlash('success', FlashMessages::PROJECT_DELETE_SUCCESS);

        return $this->redirectToRoute('project_list');
    }
}
