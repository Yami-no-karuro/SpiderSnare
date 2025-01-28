<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="description" content="<?php echo $description; ?>" />
  <meta name="author" content="<?php echo $author; ?>">
  <meta charset="utf-8">
  <title> <?php echo $title; ?> </title>
</head>

<body>
  <ul>
    <?php foreach ($links as $link) { ?>
      <li>
        <a href="<?php echo $link['path']; ?>"
          alt="<?php echo $link['description']; ?>">
          <?php echo $link['name']; ?>
        </a>
      </li>
    <?php } ?>
  </ul>
</body>

</html>
