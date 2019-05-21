
<?php

session_start();

$id=$_SESSION['id'];
$max_credit= $_SESSION['max_credit'];

?>

<?php
if (isset($_POST['submit'])) {
  require "../config.php";
  require "../common.php";

  try {
  echo "Transaction Started."."<br>";
    $connection = new PDO($dsn, $username, $password, $options);

    $new_transaction = array(
      "id1" => $_POST['id1'],
      "id2"  => $_POST['id2'],
      "transfer_amount"     => $_POST['transfer_amount'],
      "date"      => $_POST[date()]
    );
  
    $sql01 = sprintf(
"INSERT INTO %s (%s) values (%s)", 
"transactions",
implode(", ", array_keys($new_transaction)),
":" . implode(", :", array_keys($new_transaction))
    );

    $statement1 = $connection->prepare($sql01);
    $statement1->execute($new_transaction);
    echo "Transaction Saved!"."<br>";
     
  } catch(PDOException $error) {
    echo $sql01 . "<br>" .$error->getMessage();
  }

  try{
    echo "Updating Balances ... "."<br>";
    $connection = new PDO($dsn, $username, $password, $options);
    
    $max_credit=$max_credit-$_POST['transfer_amount'];
    
    $sql = "UPDATE users
            SET credit = $max_credit
            WHERE id = $id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':credit', $max_credit);
  
    $user =[
      "credit" => $max_credit,
    ];
  
    $statement->execute($user);
    
  
  } catch(PDOException $error){
      echo $sql . "<br>" .$error->getMessage();
  }

  try{

    $connection = new PDO($dsn, $username, $password, $options);
    $id2 = $_POST['id2'];
    $sql3 = "SELECT * FROM users WHERE id = :id2";

    $statement3 = $connection->prepare($sql3);
    $statement3->bindValue(':id2', $id2);
    $statement3->execute();
    $user = $statement3->fetch(PDO::FETCH_ASSOC);
    $credit = $user['credit'];

    $connection = new PDO($dsn, $username, $password, $options);
    
    $credit=$credit+$_POST['transfer_amount'];
    
    $sql = "UPDATE users
            SET credit = $credit
            WHERE id = $id2";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id2);
    $statement->bindValue(':credit', $credit);
  
    $user =[
      "credit" => $credit,
    ];
  
    $statement->execute($user);
    echo "Balances Successfully Updated!"."<br>";

    if($statement)
        echo escape("Transfer Successful!");
  
  } catch(PDOException $error){
      echo $sql . "<br>" .$error->getMessage();
  }
}
?>

<?php

/**
  * List all users with a link to edit
  */

  try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql2 = "SELECT id,firstname,lastname FROM users ";
    
    $statement2 = $connection->prepare($sql2);
    $statement2->execute();

    $result = $statement2->fetchAll();
  } catch(PDOException $error) {
    echo $sql2 . "<br>" . $error->getMessage();
  }
?>

<?php require "templates/header.php"; ?>

<div align="right">
  <button class="pagination" >
  <a href="index.php">Back to home</a>
</button>
</div>
<h2>Transfer Details</h2>
<div class="container">
  <form method="post" class="form-horizontal">
    <div class="form-group">
      <input type="hidden" name="id1" value="<?php echo escape($id); ?>" required>
      <Label>Transfer to :</Label>
      <select name="id2" size="5" class="form-control" required>
        <?php foreach ($result as $row) : ?>
        <?php if( $row["id"] != $id ) { ?>  
          <option name="id2" value="<?php echo escape($row["id"]); ?>">
            <tr>
              <td><?php echo escape($row["id"]); ?></td>
              <td><?php echo escape($row["firstname"]); ?></td>
              <td><?php echo escape($row["lastname"]); ?></td>
            </tr>
          </option>
         <?php } ?> 
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="transfer_amount">Transfer Amount :</label>
      <input type="number" name="transfer_amount" min="1" max="<?php echo escape($max_credit); ?>" class="form-control" required>
    </div>
    <br>
    <br>
    <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block" >
  </form>
</div>

<?php require "templates/footer.php"; ?>
