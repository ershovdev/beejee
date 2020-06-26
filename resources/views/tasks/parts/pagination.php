<nav>
    <ul class="pagination">
        <li class="page-item <?php echo $paginationButtons['back']['active'] ? '' : 'disabled' ?>">
            <a class="page-link"
               href="<?php echo $paginationButtons['back']['url'] ?>">
                Prev
            </a>
        </li>

        <?php for($i = 0; $i < $numberOfTasks / 3; $i++): ?>
            <?php $url = \Core\Url::generate('/tasks', ['page' => $i + 1, 'column' => $column, 'order' => $_GET['order'] ?? 'ASC']); ?>
            <li class="page-item <?php echo $paginationButtons['current'] === $i ? 'active' : '' ?>">
                <a class="page-link"
                   href="<?php echo $url ?>">
                    <?php echo $i + 1 ?>
                </a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?php echo $paginationButtons['next']['active'] ? '' : 'disabled' ?>">
            <a class="page-link"
               href="<?php echo $paginationButtons['next']['url'] ?>">
                Next
            </a>
        </li>
    </ul>
</nav>
