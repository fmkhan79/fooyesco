<?php
$exploded = explode('/', $page_name);
$parent_dir = $exploded[0];
$file_name  = $exploded[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- METAS -->
    <?php include "partials/metas.php"; ?>
    <!-- STYLES -->
    <?php include 'partials/styles.php'; ?>
</head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-S5Z3LWGTDL"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-S5Z3LWGTDL');
</script>
<body>
    <!-- MAIN CONTENT -->
    <?php include $page_name . '.php'; ?>
    <!-- FOOTER -->
    <?php include 'partials/footer.php'; ?>
    <!-- SCRIPTS -->
    <?php include 'partials/scripts.php'; ?>
    <!-- MODAL -->
    <?php include 'partials/modal.php'; ?>

</body>
</html>
