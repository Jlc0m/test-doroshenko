<div class="modal fade" id="coursesModal" tabindex="-1" aria-labelledby="coursesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <?php
                        $colors = ['text-blue', 'text-green', 'text-orange', 'text-purple', 'text-teal'];
                        foreach ($courses as $index => $course):
                            $colorClass = $colors[$index % count($colors)];
                        ?>
                            <div class="col-md-4 mb-4">
                                <div class="card course-card">
                                    <div class="card-body">
                                        <h5 class="card-title <?= $colorClass ?>">
                                            <i class="fas fa-check-circle"></i>
                                            <?= htmlspecialchars($course['title']) ?>
                                        </h5>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($course['lessons'] as $lesson): ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center <?= $colorClass ?>">
                                                    <span>
                                                        <i class="fas fa-arrow-right"></i>
                                                        <?= htmlspecialchars($lesson['title']) ?>
                                                    </span>
                                                    <button class="btn btn-outline-primary rounded-pill">Іде набір</button>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>