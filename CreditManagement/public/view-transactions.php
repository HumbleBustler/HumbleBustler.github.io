
<?php

/**
  * List all users with a link to edit
  */

  try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM transactions";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
?>
<?php require "templates/header.php"; ?>

<h2>All Users</h2>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Origin_Id</th>
        <th>Destination_Id</th>
        <th>Transaction_Amount</th>
        <th>Date-Time</th>
      </tr>
    </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id1"]); ?></td>
          <td><?php echo escape($row["id2"]); ?></td>
          <td><?php echo escape($row["transfer_amount"]); ?></td>
          <td><?php echo escape($row["DATE"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
  </table>
</div>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
