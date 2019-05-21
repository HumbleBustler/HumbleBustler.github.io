<?php

session_start();

?>
<?php
/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "id"        => $_POST['id'],
      "firstname" => $_POST['firstname'],
      "lastname"  => $_POST['lastname'],
      "email"     => $_POST['email'],
      "credit"    => $_POST['credit'],
      "date"      => $_POST['date']
    ];

    $sql = "UPDATE users
            SET id = :id,
              firstname = :firstname,
              lastname = :lastname,
              email = :email,
              credit = :credit,
              date = :date
            WHERE id = :id";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $max_credit = $user['credit'];


    $_SESSION['id'] = $id;
    $_SESSION['max_credit'] = $max_credit;

    
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>
<?php if (isset($_POST['submit']) && $statement) : ?>
  <?php echo escape("Transaction Successful")?> updated.
<?php endif; ?>
<div class="container">
  <form method="post" class="form-horizontal">
    <?php foreach ($user as $key => $value) : ?>
      <div class="form-group">
        <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
        <input class="form-control" type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?> readonly>
      </div>
    <?php endforeach; ?>
  </form>
</div>

<button class="pagination">
  <a href="transfer.php" >Transfer Credits</a>
</button>
<button class="pagination" >
  <a href="index.php" >Back to home</a>
</button>

<?php require "templates/footer.php"; ?>