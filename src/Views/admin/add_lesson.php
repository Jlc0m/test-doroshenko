<h1>Додати заняття</h1>
<form action="/admin/add-lesson" method="post">
    <div class="mb-3">
        <label for="course_id" class="form-label">Курс</label>
        <select class="form-control" id="course_id" name="course_id" required>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Назва заняття</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <button type="submit" class="btn btn-primary">Додати</button>
</form>