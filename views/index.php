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
    <?php if (isset($_SESSION['error'])) : ?>
      <p class="text-center text-danger">
        <?= $_SESSION['error']; ?>
      </p>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="text" name="title">
        <?php if (isset($_SESSION['errorTitle'])) : ?>
          <code>
            <?= $_SESSION['errorTitle']; ?>
          </code>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="body" class="form-label">Body</label>
        <textarea class="form-control" id="body" name="message" rows="3"></textarea>
        <?php if (isset($_SESSION['errorMessage'])) : ?>
          <code>
            <?= $_SESSION['errorMessage']; ?>
          </code>
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
                <?= $post->getTitle(); ?>
              </strong>
              <p class="display-6">
                <?= nl2br($post->getMessage()); ?>
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

  </div>
</body>

</html>