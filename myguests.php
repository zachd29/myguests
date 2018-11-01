<?
/********************************************
| MyGuest Application
| Version 1.0
| Zachary Derby
********************************************/

/********************************************
| CONTENTS:
| Database Credentials
| Update form
| Registration form
| Function to ADD a guest
| Function to UPDATE a guest
| Function to DELETE a guest
| Function to LIST a guest
********************************************/




/********************************************
|| DB Credentials
********************************************/
$servername = "localhost";
$username = "zachd29";
$password = "carmella1";
$dbname = "jaxcode54";
//end




/******************************************
| Update form
*******************************************/
$updateform = '<h2>Update Guest</h2><form action="index.php" method="POST">
<input type ="hidden" name="id" value="'.$_POST['id']. '">
<div class="form-group">
    <label for="firstname">Firstname:</label>
   <input type="text" class="form-control" name="firstname" value=" '.$_POST['firstname']. '" required>
   </div>
   
   <div class="form-group">
    <label for="lastname">Lastname:</label>
   <input type="text" class="form-control" name="lastname" value=" '.$_POST['lastname']. '" required>
   </div>
   <div class="form-group">
    <label for="email">email:</label>
   <input placeholder="This must be valid" type="email" class="form-control" name="email" value="'.$_POST['email']. '" required> 
   </div>
   <input type="submit" name="updateguest" class="btn btn-info" value="Update">
</form>';
// end


/******************************************
| Registration form
*******************************************/
$registrationform = '<h2>Please Register</h2><form action="index.php" method="POST">
   <div class="form-group">
    <label for="firstname">Firstname:</label>
   <input type="text" class="form-control" name="firstname" required>
   </div>
   <div class="form-group">
    <label for="lastname">Lastname:</label>
   <input type="text" class="form-control" name="lastname" required>
   </div>
   <div class="form-group">
    <label for="email">Email address:</label>
    <input placeholder="This must be valid" type="email" class="form-control" name="email" required >
   </div>
   <input type="submit" name="addguest" class="btn btn-info" value="submit">
</form>';
// end





/******************************************
| Function to ADD a guest
*******************************************/

function addguest($servername,$username,$password,$dbname)  {
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize incoming $_POST variables
$firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
$lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('{$firstname}', '{$lastname}', '{$email}')";

if (mysqli_query($conn, $sql)) {
echo '<div class="alert alert-success" role="alert">
  Guest Added
</div>';

 // Send email to admin
      $to = "zachd29@hotmail.com";
      $subject = "Guest Added";
      $txt = "$firstname $lastname was added to the database";
      $headers = "From: webmaster@example.com";

      mail($to,$subject,$txt,$headers);

} else {
    echo '<div class="alert alert-danger" role="alert">
  error
 ' . $sql . '</div>' . mysqli_error($conn);
}

mysqli_close($conn);
}
//end




/******************************************
| Function to UPDATE a guest
*******************************************/

function updateguest($servername,$username,$password,$dbname) {

// Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "UPDATE MyGuests SET firstname='{$_POST['firstname']}', lastname='{$_POST['lastname']}', email='{$_POST['email']}' WHERE id={$_POST['id']}"; 

if (mysqli_query($conn, $sql)) {
   echo '<div class="alert alert-success">
  Guest Updated
</div>';
} else {
    echo '<div class="alert alert-danger">
  error
 ' . $sql . '</div>' . mysqli_error($conn);
}

mysqli_close($conn);

}
//end




/******************************************
| Function to DELETE a guest
*******************************************/

function deleteguest($servername,$username,$password,$dbname) {

// Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$sql = "DELETE FROM MyGuests WHERE id={$_POST['id']}";

if (mysqli_query($conn, $sql)) {
   echo '<div class="alert alert-danger">
  Guest Deleted
</div>';
} else {
    echo '<div class="alert alert-danger">
  error
 ' . $sql . '</div>' . mysqli_error($conn);
}

mysqli_close($conn);

}
//end




/******************************************
| Function to LIST Guests
*******************************************/

function listguests($servername,$username,$password,$dbname) {


// Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// READING the Data
$sql = "SELECT id, firstname, lastname, email FROM MyGuests";
$result = mysqli_query($conn,  $sql);
?>
<br><br>

<!-- Guest List -->
<h2>Guest List</h2>

<table class="table table-striped table-hover table-responsive table-bordered">
<tr>
<th>Firstname</th>
<th>LastName</th>
<th>Email</th>
<th>Edit</th>
<th>Delete</th>
   </tr>

<?
if (mysqli_num_rows($result) > 0) {
     // output data of each row

     while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td>
  <?=$row["firstname"]?>
</td><td>
  <?=$row["lastname"]?>
</td><td>
  <?=$row["email"]?>
</td>
  <td>
 <form action="index.php" method="POST">
  <input type="hidden" name="id" value="<?=$row['id']?>">
  <input type="hidden" name="firstname" value="<?=$row['firstname']?>">
  <input type="hidden" name="lastname" value="<?=$row['lastname']?>">
  <input type="hidden" name="email" value="<?=$row['email']?>">
  <input type="submit" name="editthis" value="Edit" class="btn btn-success btn-xs">
</form>
</td>   
<td>
<form action="index.php" method="POST">
  <input type="hidden" name="id" value="<?=$row['id']?>">
  <input type="submit" name="deletethis" value="Delete" class="btn btn-danger btn-xs">
</form>
</td>
</tr>
<?
   }
} else {
    echo '<div class="alert alert-info">
  Zero record found
</div>';
}
echo '</table>
<!-- /Guest Lit -->';
mysqli_close($conn);

}
//end
