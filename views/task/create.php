<div class="col-md-6">
    <div class="">
        <form class="form-horizontal contact-form" role="form" method="post" action="/task/create">
            <div class="form-group">
                <div class="col-md-12">
                    <label for="name">Имя:</label>
                    <input type="text" class="form-control border" name="name" id="name">
                </div>
                <div class="col-md-12">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control border" name="email" id="email">
                </div>
                <div class="col-md-12">
                    <label for="text">Текст задачи:</label>
                    <textarea class="form-control border" name="text" id="text" cols="30" rows="10"></textarea>
                </div>
            </div>
            <button type="submit" class="btn send-btn">Создать задачу</button>
        </form>
    </div>
</div>