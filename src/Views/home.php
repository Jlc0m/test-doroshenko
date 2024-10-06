<div class="row mb-4">
    <div class="col-md-4">
        <div class="text-center text-md-start">
            <h1 class="mb-3">Стань Лідером
                Сьогодні!</h1>
            <h5 class="mb-4">Відкрийте свій потенціал і навчіться вести за собою команду до успіху. Наші курси допоможуть вам здобути навички, які змінять ваше лідерство на краще. Підніміть свою кар'єру на новий рівень разом із нами!</h5>
            <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-start">
                <a href="#" class="btn btn-primary me-md-2">АКТУАЛЬНІ</a>
                <a href="#" class="btn btn-warning mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#coursesModal">УСІ КУРСИ</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($sliderItems as $index => $item): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= $item['image_url'] ?>" class="d-block w-100" alt="<?= $item['title'] ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= $item['title'] ?></h5>
                            <p><?= $item['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Попередній</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Наступний</span>
            </button>
        </div>
    </div>
</div>

<h2 class="mb-4">Файли</h2>

<div class="mb-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
    <div class="mb-2 mb-md-0 d-flex align-items-center">
        <div class="form-check form-check-inline">
            <input type="checkbox" id="selectAll" class="form-check-input me-2">
            <label for="selectAll" class="form-check-label">Вибрати все</label>
        </div>
        <div class="vr me-2 d-none d-md-block"></div>
        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addFileModal"><i class="fas fa-upload"></i></button>
        <button id="downloadSelected" class="btn btn-primary me-2" disabled><i class="fas fa-download"></i></button>
        <button id="shareSelected" class="btn btn-secondary me-2" disabled><i class="fas fa-share"></i></button>
        <button id="deleteSelected" class="btn btn-danger me-2" disabled><i class="fas fa-trash"></i></button>
    </div>
    <div class="mt-2 mt-md-0 d-flex align-items-center">
        <select id="sortFiles" class="form-select">
            <option value="date_desc" selected>Дата (найновіші спочатку)</option>
            <option value="date_asc">Дата (найстаріші спочатку)</option>
            <option value="name_asc">Ім'я (А-Я)</option>
            <option value="name_desc">Ім'я (Я-А)</option>
        </select>
        <i id="sortDirection" class="fa-solid fa-arrow-down-short-wide ms-2"></i>
    </div>
</div>

<div class="row" id="fileList">
    <?php foreach ($files as $file): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card file-card" data-id="<?= $file['id'] ?>" data-path="<?= htmlspecialchars($file['path']) ?>">
                <div class="card-body">
                    <div class="file-preview">
                        <?php if (strpos($file['type'], 'image/') === 0): ?>
                            <img src="/<?= htmlspecialchars($file['path']) ?>" alt="<?= htmlspecialchars($file['name']) ?>">
                        <?php else: ?>
                            <i class="fas fa-file fa-4x text-secondary"></i>
                        <?php endif; ?>
                    </div>
                    <div class="file-info">
                        <div class="form-check">
                            <input class="form-check-input file-select" type="checkbox" value="<?= $file['id'] ?>">
                            <label class="form-check-label" for="fileCheck<?= $file['id'] ?>">
                                <h5 class="card-title"><?= htmlspecialchars($file['name']) ?></h5>
                            </label>
                        </div>
                        <p class="card-text">Тип: <?= htmlspecialchars(substr($file['type'], 0, 15)) . (strlen($file['type']) > 15 ? '...' : '') ?></p>
                        <p class="card-text mb-3">Створено: <?= date('Y-m-d H:i:s', strtotime($file['created_at'])) ?></p>
                    </div>
                    <div class="btn-group d-flex flex-wrap mt-auto" role="group">
                        <a href="/<?= htmlspecialchars($file['path']) ?>" class="btn btn-primary btn-sm flex-fill" download><i class="fas fa-download"></i></a>
                        <button class="btn btn-secondary btn-sm flex-fill share-file" data-path="<?= htmlspecialchars($file['path']) ?>" onclick="fallbackCopyTextToClipboard(this)"><i class="fas fa-share"></i></button>
                        <a href="#" class="btn btn-warning btn-sm flex-fill update-file" data-id="<?= $file['id'] ?>" data-name="<?= htmlspecialchars($file['name']) ?>"><i class="fas fa-edit"></i></a>
                        <a href="/delete-file/<?= $file['id'] ?>" class="btn btn-danger btn-sm flex-fill delete-file"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include __DIR__ . '/popups/add_file_popup.php'; ?>
<?php include __DIR__ . '/popups/edit_file_popup.php'; ?>