<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bulletin Board Level 1</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <div class="container py-5">


    <form action="" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="text" name="title" value="<?= isset(session()->get('old')['title']) ? session()->get('old')['title'] : '' ?>">

        <?php if (isset(session()->get('errors')['title'])) : ?>
          <?php foreach (session()->get('errors')['title'] as $error) : ?>
            <div>
              <code>
                <?= $error; ?>
              </code>
            </div>
          <?php endforeach ?>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="body" class="form-label">Body</label>
        <textarea class="form-control" id="body" name="message" rows="3"><?= isset(session()->get('old')['message']) ? session()->get('old')['message'] : '' ?></textarea>
        <?php if (isset(session()->get('errors')['message'])) : ?>
          <?php foreach (session()->get('errors')['message'] as $error) : ?>
            <div>
              <code>
                <?= $error; ?>
              </code>
            </div>
          <?php endforeach ?>
        <?php endif; ?>
      </div>

      <div class="d-grid">
        <button class="btn btn-primary mb-5" type="submit" name="send">Submit</button>
      </div>
    </form>

    <?php if ($posts) : ?>
      <?php foreach ($posts as $post) : ?>
        <div class="showData border-top py-4">
          <div class="row">
            <div class="col-8">
              <strong>
                <?= htmlspecialchars($post->getTitle()); ?>
              </strong>
              <p class="display-6">
                <?= nl2br(htmlspecialchars($post->getMessage())); ?>
              </p>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-end">
              <?= date_format($post->getCreatedAt(), "Y-m-d H:i:s"); ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    <?php else : ?>
      <div class="d-flex flex-column align-items-center">
        <h3 class="text-secondary">Oppss Sorry, Data Is Empty</h3>
        <img src="img/undraw_Empty_re_opql.png" alt="image data empty" class="image-empty">
      </div>
    <?php endif; ?>

    <hr>

    <?php if ($current != 1) : ?>
      <a href="?page=<?= $current - 1; ?>">&laquo;</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $pages; $i++) : ?>
      <?php if ($i == $current) : ?>
        <a><?= $i; ?></a>
      <?php else : ?>
        <a href="?page=<?= $i; ?>"><?= $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>

    <?php if ($current != $pages) : ?>
      <a href="?page=<?= $current + 1; ?>">&raquo;</a>
    <?php endif; ?>

  </div>
</body>

</html>