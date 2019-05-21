
<?php

/**
  * List all users with a link to edit
  */

  try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM users";

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
        <th>Id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email Address</th>
        <th>Credit</th>
        <th>Date</th>
        <th>Edit</th>
      </tr>
    </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["firstname"]); ?></td>
          <td><?php echo escape($row["lastname"]); ?></td>
          <td><?php echo escape($row["email"]); ?></td>
          <td><?php echo escape($row["credit"]); ?> </td>
          <td><?php echo escape($row["DATE"]); ?> </td>
          <td><a href="view-single.php?id=<?php echo escape($row["id"]); ?>">View</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
  </table>
</div>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
