<?php if (!$pagination->isEmpty()) : ?>
    <nav aria-label="Page navigation example" class="border-top pt-5">
        <ul class="pagination justify-content-center">

            <?php if ($pagination->hasPrevious()) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pagination->previousPage() ?>" aria-label=" Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif ?>

            <?php foreach ($pagination->buildPaginations() as $paginate) : ?>
                <?php if ($paginate === $pagination->currentPage()) : ?>
                    <span class="page-link active">
                        <?= $paginate; ?>
                    </span>
                <?php else : ?>
                    <a class="page-link" href="<?= $pagination->pageLink($paginate) ?>">
                        <?= $paginate; ?>
                    </a>
                <?php endif ?>
            <?php endforeach ?>

            <?php if ($pagination->hasNext()) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pagination->nextPage() ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif ?>

        </ul>
    </nav>
<?php endif ?>