<?php

namespace App\Controllers;

use App\Models\Auth;
use App\Validators\TaskEditValidator;
use App\Validators\TaskIndexParametersValidator;
use App\Validators\TaskStoreValidator;
use Core\Helpers;
use Core\Url;
use Core\View;
use Doctrine\ORM\EntityManager;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    public function show()
    {
        $page = $_GET['page'] ?? 1;
        $column = $_GET['column'] ?? 'id';
        $order = $_GET['order'] ?? 'ASC';
        $data = array(
            'page' => $page,
            'column' => $column,
            'order' => $order,
        );

        $validator = new TaskIndexParametersValidator($data);
        $result = $validator->validate();

        if ($result === true) {
            $task = new Task($this->entityManager);
            $tasks = $task->getPaginator($page, $column, $order);
            $isAdmin = Auth::isLoggedIn($this->cookieId, $this->cookieHash);

            $numberOfTasks = count($tasks);

            $paginationButtons = [
                'back' => [
                    'active' => $page != 1,
                    'url' => Url::generate('/tasks', [
                        'page' => $page > 1 ? $page - 1 : 1,
                        'column' => $column,
                        'order' => $order,
                    ]),
                ],
                'current' => $page > 1 ? $page - 1 : 0,
                'next' => [
                    'active' => $page == 1 || $page * 3 < $numberOfTasks,
                    'url' => Url::generate('/tasks', [
                        'page' => $page + 1,
                        'column' => $column,
                        'order' => $order,
                    ]),
                ],
            ];

            $this->view->show('tasks/index', array(
                'tasks' => $tasks,
                'isAdmin' => $isAdmin,
                'ascOrDesc' => $order === 'ASC' ? 'DESC' : 'ASC',
                'paginationButtons' => $paginationButtons,
                'column' => $column,
                'numberOfTasks' => $numberOfTasks,
            ));
        } else {
            Helpers::setErrors($result);
            Helpers::redirect('/tasks');
        }
    }

    public function create()
    {
        $this->view->show('tasks/create');
    }

    public function store()
    {
        $data = array(
            'email' => $_POST['email'],
            'username' => htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'),
            'status' => 0,
            'text' => htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8'),
        );

        $validator = new TaskStoreValidator($data);
        $result = $validator->validate();

        if ($result === true) {
            $task = new Task($this->entityManager);
            $task->store($data);

            $_SESSION['success'] = "Task were added successfully!";
            header('Location: /tasks');
        } else {
            $_SESSION['errors'] = $result;
            header('Location: /tasks/add');
        }
    }

    public function complete(int $id)
    {
        if (!Auth::isLoggedIn($this->cookieId, $this->cookieHash)) {
            $_SESSION['errors'] = [0 => "You're not allowed to do that"];
            header('Location: /tasks');
            return;
        }

        $task = new Task($this->entityManager, $id);
        $result = $task->setStatus(1);

        if ($result) {
            $_SESSION['success'] = 'Task were successfully completed!';
            header('Location: /tasks');
        } else {
            $_SESSION['errors'] = [0 => 'Something went wrong'];
            header('Location: /tasks');
        }
    }

    public function edit(int $id)
    {
        if (!Auth::isLoggedIn($this->cookieId, $this->cookieHash)) {
            $_SESSION['errors'] = [0 => "You're not allowed to do that"];
            header('Location: /tasks');
            return;
        }

        $task = new Task($this->entityManager, $id);
        $this->view->show('tasks/edit', [
            'task' => $task->getTask(),
        ]);
    }

    public function update(int $id)
    {
        if (!Auth::isLoggedIn($this->cookieId, $this->cookieHash)) {
            $_SESSION['errors'] = [0 => "You're not allowed to do that"];
            header('Location: /tasks');
            return;
        }

        $task = new Task($this->entityManager, $id);
        $data = array(
            'text' => Helpers::escape($_POST['text']),
        );

        $validator = new TaskEditValidator($data);
        $result = $validator->validate();

        if ($result === true) {
            $task->update($data);

            $_SESSION['success'] = "Task were added successfully!";
            header('Location: /tasks');
        } else {
            $_SESSION['errors'] = $result;
            header("Location: /tasks/{$task->getTask()->getId()}/edit");
        }
    }
}