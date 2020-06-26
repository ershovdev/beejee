<?php

namespace App\Models;

use Doctrine\ORM\EntityManager;

class Task
{
    private $entityManager;
    private $task;

    public function __construct(EntityManager $entityManager, int $id = null)
    {
        $this->entityManager = $entityManager;
        if ($id)
            $this->task = $this->entityManager->getRepository('\Src\Task')->findOneBy(array('id' => $id));
    }

    public function store(array $data)
    {
        $task = new \Src\Task();

        $user = $this->entityManager->find('\Src\User', 1);

        $task->setUser($user);
        $task->setEmail($data['email']);
        $task->setUsername($data['username']);
        $task->setStatus(0);
        $task->setText($data['text']);
        $task->setCreatedAt(new \DateTime());
        $task->setEdited(0);

        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function update($data)
    {
        $previous_text = $this->task->getText();
        if ($data['text'] === $previous_text) return;
        $this->task->setText($data['text']);
        $this->task->setEdited(1);

        $this->entityManager->persist($this->task);
        $this->entityManager->flush();
    }

    public function getPaginator(int $page, string $column, string $order)
    {
        return $this->entityManager->getRepository('\Src\Task')
            ->getPaginator($page, $column, $order);
    }

    public function setStatus(int $status)
    {
        $this->task->setStatus($status);
        $this->entityManager->persist($this->task);
        $this->entityManager->flush();

        return true;
    }

    public function getTask()
    {
        return $this->task;
    }
}