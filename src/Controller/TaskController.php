<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     * @param TaskRepository $taskRepository
     * @return Response
     */
    public function listAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findAll();
        return $this->render('task/list.html.twig', ['tasks' => $tasks]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserInterface $user
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request, EntityManagerInterface $entityManager, UserInterface $user)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setAuthor($user);
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{taskId}/edit", name="task_edit")
     * @param string $taskId
     * @param TaskRepository $taskRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function editAction(string $taskId, TaskRepository $taskRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $task = $taskRepository->find($taskId);
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{taskId}/toggle", name="task_toggle")
     * @param string $taskId
     * @param TaskRepository $taskRepository
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function toggleTaskAction(string $taskId, TaskRepository $taskRepository, EntityManagerInterface $entityManager): RedirectResponse
    {
        $task = $taskRepository->find($taskId);
        $task->toggle(!$task->isDone());
        $entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{taskId}/delete", name="task_delete")
     * @param string $taskId
     * @param TaskRepository $taskRepository
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function deleteTaskAction(string $taskId, TaskRepository $taskRepository, EntityManagerInterface $entityManager): RedirectResponse
    {
        $task = $taskRepository->find($taskId);
        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
