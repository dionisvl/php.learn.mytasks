<div class="page-header">
    <h1>Изменение задачи #<?= $task['id'] ?></h1>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="">
            <form class="form-horizontal contact-form" role="form" method="post" action="/task/<?= $task['id'] ?>">
                <!--<input type="hidden" name="user_id" id="user_id" value="-->
                <? //= $_SESSION['user']['id'] ?><!--" required>-->
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="name">Имя:</label>
                        <input type="text" class="form-control border" name="name" id="name"
                               value="<?= $task['name'] ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control border" name="email" id="email"
                               value="<?= $task['email'] ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="text">Текст задачи:</label>
                        <textarea class="form-control border" name="text" id="text" cols="30"
                                  rows="10"><?= $task['text'] ?></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="status">Статус:</label>
                        <select id="status" name="status" class="form-control border">
                            <option value="NEW" <? if ($task['status'] == 'NEW') echo 'selected'; ?>>Новая</option>
                            <option value="RESOLVED" <? if ($task['status'] == 'RESOLVED') echo 'selected'; ?>>
                                Выполненная
                            </option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn send-btn">Сохранить</button>
            </form>
        </div>
    </div>
</div>