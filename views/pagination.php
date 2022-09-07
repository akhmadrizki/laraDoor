<nav aria-label="Page navigation example" class="border-top pt-5 <?= $total <= 1 ? 'd-none' : 'd-block' ?>">
    <ul class="pagination justify-content-center">

        <?php if ($currentPage != 1) : ?>
            <li class="page-item">
                <a class="page-link" href="?<?= $getUrl ?>=<?= $currentPage - 1; ?>" aria-label=" Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total; $i++) : ?>
            <li class="page-item">
                <?php if ($i == $currentPage) : ?>
                    <span class="page-link active">
                        <?= $i; ?>
                    </span>
                <?php else : ?>
                    <a class="page-link" href="?<?= $getUrl ?>=<?= $i; ?>">
                        <?= $i; ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endfor; ?>

        <?php if ($currentPage != $total) : ?>

            <li class="page-item">
                <a class="page-link" href="?<?= $getUrl ?>=<?= $currentPage + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</nav>