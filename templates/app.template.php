<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="description" content="<?php echo $description; ?>" />
  <meta name="author" content="<?php echo $author; ?>">
  <meta charset="utf-8">
  <title> <?php echo $title; ?> </title>
</head>

<body>
  <main>
    <section>
      <div style="text-align: center; 
        margin: 45px 0;">
        <ul style="list-style: none;">
          <?php foreach ($links as $link) { ?>
            <li>
              <a href="<?php echo $link['path']; ?>"
                alt="<?php echo $link['description']; ?>">
                <?php echo $link['name']; ?>
              </a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </section>
  </main>
</body>

</html>
