<div>
    <h3 class="mb-3">Tasks Page</h3>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">
                Username
                <a href="tasks?page=<?php echo $_GET['page'] ?? 1 ?>&column=username&order=<?php echo $ascOrDesc; ?>">
                    <i class="fa fa-sort"></i>
                </a>
            </th>
            <th scope="col">
                Email
                <a href="tasks?page=<?php echo $_GET['page'] ?? 1 ?>&column=email&order=<?php echo $ascOrDesc; ?>">
                    <i class="fa fa-sort"></i>
                </a>
            </th>
            <th scope="col">Text</th>
            <th scope="col">
                Status
                <a href="tasks?page=<?php echo $_GET['page'] ?? 1 ?>&column=status&order=<?php echo $ascOrDesc; ?>">
                    <i class="fa fa-sort"></i>
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <th scope="row"><?php echo $task->getId() ?></th>
                <td><?php echo $task->getUsername() ?></td>
                <td><?php echo $task->getEmail() ?></td>
                <td>
                    <?php echo $task->getText() ?>
                    <a class="btn btn-sm btn-primary ml-2 <?php echo $isAdmin ? '' : 'disabled' ?>"
                       href="tasks/<?php echo $task->getId() ?>/edit"
                       role="button">
                        Edit
                    </a>
                    <?php if ($task->isEdited()): ?>
                        <p class="small mt-2">Edited by Admin</p>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo $task->getStatus() ? 'Completed' : 'In process' ?>
                    <?php if (!$task->getStatus()): ?>
                    <form action="/tasks/<?php echo $task->getId() ?>/complete"
                          method="POST"
                          style="display: none;"
                          id="complete_form_<?php echo $task->getId() ?>">

                    </form>
                    <button class="ml-2 btn btn-sm btn-primary" <?php echo $isAdmin ? '' : 'disabled' ?>
                            onclick="document.getElementById('complete_form_<?php echo $task->getId() ?>').submit()">
                        Complete
                    </button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php require_once 'parts/pagination.php'?>
</div>