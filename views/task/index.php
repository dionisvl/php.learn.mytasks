<div class="page-header">
    <h1>
        Список задач
    </h1>
</div>
<div class="row">
    <div class="col-md-12">

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Имя пользователя
                    <a href="/?orderBy=name&orderDirection=ASC">
                        <i class="fas fa-sort-amount-up"></i>
                    </a>
                    <a href="/?orderBy=name&orderDirection=DESC">
                        <i class="fas fa-sort-amount-down-alt"></i>
                    </a>
                </th>
                <th>Email
                    <a href="/?orderBy=email&orderDirection=ASC">
                        <i class="fas fa-sort-amount-up"></i>
                    </a>
                    <a href="/?orderBy=email&orderDirection=DESC">
                        <i class="fas fa-sort-amount-down-alt"></i>
                    </a>
                </th>
                <th>Текст задачи</th>
                <th>Статус
                    <a href="/?orderBy=status&orderDirection=ASC">
                        <i class="fas fa-sort-amount-up"></i>
                    </a>
                    <a href="/?orderBy=status&orderDirection=DESC">
                        <i class="fas fa-sort-amount-down-alt"></i>
                    </a>
                </th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($tasks as $task) { ?>
                <tr>
                    <td><?= $task['name'] ?> (задача № <?= $task['id'] ?>)</td>
                    <td><?= $task['email'] ?></td>
                    <td><?= $task['text'] ?></td>
                    <td>
                        <? if ($task['status'] == 'RESOLVED') { ?>
                            <span class="badge badge-pill badge-success">выполнено</span>
                        <? } else { ?>
                            <span class="badge badge-pill badge-secondary"><?= $task['status'] ?></span>
                        <? } ?>
                        <? if ($task['edited'] == '1') { ?>
                            <span class="badge badge-info">отредактировано администратором</span>
                        <? } ?>
                    </td>
                    <td>
                        <? if (isAdmin()) { ?>
                            <a href="/task/<?= $task['id'] ?>/edit"><i class="fas fa-pencil-alt"></i></a>
                        <? } ?>
                    </td>
                </tr>
            <? } ?>
            </tbody>
        </table>

        <nav class="m-2">
            <ul class="pagination">
                <? for ($i = 1; $i <= $pagesCount; $i++) {
                    if (($i == 1) and ($curPage != 1)) { ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $curPage - 1 ?>">Previous</a>
                        </li>
                    <? } ?>
                    <li class="page-item <? if ($i == $curPage) { ?>active<? } ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <? if (($i == $pagesCount) and ($curPage != $pagesCount)) { ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $curPage + 1 ?>">Next</a>
                        </li>
                    <? }
                } ?>
            </ul>
        </nav>
    </div>
</div>