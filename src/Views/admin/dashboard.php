<div class="row">
    <div class="col-md-6">
        <h2>Курси</h2>
        <ul class="list-group">
            <?php foreach ($courses as $course): ?>
                <li class="list-group-item"><?= htmlspecialchars($course['title']) ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="/admin/add-course" class="btn btn-primary mt-3">Додати курс</a>
    </div>
    <div class="col-md-6">
        <h2>Заняття</h2>
        <a href="/admin/add-lesson" class="btn btn-primary">Додати заняття</a>
    </div>
</div>