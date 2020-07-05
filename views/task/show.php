<div class="page-header">
    <h1>Просмотр задачи #<?= $task['id'] ?></h1>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <label for="name">Имя:</label>
                <div class="form-control border" id="name"><?= $task['name'] ?></div>
            </div>
            <div class="col-md-12">
                <label for="email">Email:</label>
                <div class="form-control border" id="email"><?= $task['email'] ?></div>
            </div>
            <div class="col-md-12">
                <label for="text">Текст задачи:</label>
                <div class="form-control border" id="text"><?= $task['text'] ?></div>
            </div>
            <div class="col-md-12">
                <label for="status">Статус:</label>
                <div class="form-control border" id="status"><?= $task['status'] ?></div>
            </div>
            <a href="/" class="button">Вернуться на главную</a>
        </div>
    </div>
</div>