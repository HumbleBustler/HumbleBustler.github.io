
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Homepage</title>

    <link rel="stylesheet" href="css/stylesheet.css" />
  </head>

  <body>
<?php include "templates/header.php"; ?>
<h1>Credit Management Application</h1>
<div class="list-group">
      <a href="view.php" class="list-group-item"><strong>View all Users</strong></a>
      <a href="view-transactions.php" class="list-group-item"><strong>Transactions<small> ( Ledger of all transactions )</small></strong></a>
</div>
<?php include "templates/footer.php"; ?>
  </body>
</html>