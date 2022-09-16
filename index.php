<?php
session_start();
unset($_SESSION['status']);
unset($_SESSION['status_code']);
if(!isset($_COOKIE['username'])){
  header("location: login.php");
  exit();
}
if($_COOKIE['username'] == 'admin@1234'){
$_SESSION['adminlogin']=true;
}
else{
require('_dbconfig.php');
    $password=$_COOKIE['password'];
    $sql= "SELECT * FROM `users` WHERE password='$password'";
    $result = mysqli_query($conn, $sql);
    $numrows = mysqli_num_rows($result);
    if($numrows==0){
    header("location: logout.php");
    exit();
    }
}
?>
<?php
$_SESSION['loggedin']=true;
$username=$_COOKIE['username'];
if (isset( $_POST['delete'])){
    $sno = $_POST['snodelete'];
    $sql = "DELETE FROM `$username` WHERE `$username`.`sn` = $sno";
    $result = mysqli_query($conn, $sql);
    if($conn->query($sql)==true)
    {
      $_SESSION['status']="Sucess! Your Note Has Been Deleted Successfully.";
      $_SESSION['status_code']="success";
      header('Location: index.php');
    }
    else{
      $_SESSION['status']='Error! Your Note Cannot Be Deleted.';
      $_SESSION['status_code']='error';
    } 
}
if($_SERVER['REQUEST_METHOD']=='POST'){
if (isset( $_POST['snoedit'])){
    // Update the record
      $sno = $_POST["snoedit"];
      $title = $_POST["titleedit"];
      $description = $_POST["descedit"];
    // Sql query to be executed
    $sql = "UPDATE `$username` SET `title` = '$title' , `des`= '$description' WHERE `$username`.`sn` = $sno";
    $result = mysqli_query($conn, $sql);
    if($conn->query($sql)==true)
{
  $_SESSION['status']="Sucess! Your Note Has Been Updated Successfully.";
  $_SESSION['status_code']="success";
  // header('Location: index.php');
}
else{
  $_SESSION['status']='Error! Your Note Cannot Be Updated.';
      $_SESSION['status_code']='error';
  } 
  }
  else{
    // getting varibales values from form
    $title= $_POST['title'];
    $des= $_POST['des'];
    // form validation
    if($title=="" && $des==""){
      echo"<script>alert('Enter all the details');</script>";
    }
    else{
  // Making a query
$sql= "INSERT INTO `$username` (`title`, `des`) VALUES ('$title', '$des')";
if($conn->query($sql)==true)
{
  $_SESSION['status']="Sucess! Your Note Has Been Inserted Successfully.";
  $_SESSION['status_code']="success";
  // header('Location: index.php');

}
else{
  $_SESSION['status']='Error! Your Note Cannot Be Insertd.';
      $_SESSION['status_code']='error';
  } 
}
}
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8641761520904914"
     crossorigin="anonymous"></script>
  <link rel="icon" type="image/x-icon" href="favicon.png">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <title>Welcome - <?php echo $username;?></title>
  <style>
      .animate-charcter
{
   text-transform: uppercase;
  background-image: linear-gradient(
    -225deg,
    #231557 0%,
    #44107a 29%,
    #ff1361 67%,
    #fff800 100%
  );
  background-size: auto auto;
  background-clip: border-box;
  background-size: 200% auto;
  color: #fff;
  background-clip: text;
  text-fill-color: transparent;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: textclip 5s linear infinite;
  display: inline-block;
      font-size: 30px;
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}
.marquee {
        background-color: #1c87c9;
        color: #fff;
        padding: 5px;
        width=100%;
        margin=0;
      }
      .paragraph{
        -moz-animation: marquee 15s linear infinite;
        -webkit-animation: marquee 15s linear infinite;
        animation: marquee 15s linear infinite;
      }
      @-moz-keyframes marquee {
        0% {
          transform: translateX(100%);
        }
        100% {
          transform: translateX(-100%);
        }
      }
      @-webkit-keyframes marquee {
        0% {
          transform: translateX(100%);
        }
        100% {
          transform: translateX(-100%);
        }
      }
      @keyframes marquee {
        0% {
          -moz-transform: translateX(100%);
          -webkit-transform: translateX(100%);
          transform: translateX(100%)
        }
        100% {
          -moz-transform: translateX(-100%);
          -webkit-transform: translateX(-100%);
          transform: translateX(-100%);
        }
      }
  </style>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function () {
    $('#mytable').DataTable();
  });
</script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<body>

     <?php require('_nav.php');
     ?>
      <div class="container my-4">
   <div class="jumbotron jumbotron-fluid">
  <div class="container">
   <div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <h3 class="animate-charcter">Welcome - <?php echo $username;?></h3>
    </div>
  </div>
</div>
</div>
  </div>
  </div>
  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
    Edit
  </button> -->
  
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit This Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="post">
            <input type="hidden" name="snoedit" id="snoedit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleedit" name="titleedit">
            </div>
            <div class="mb-3">
              <label for="descedit" class="form-label">Note Description</label>
              <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="descedit" id=" floatingTextarea"
                name="descedit"></textarea>
                <label for="descedit floatingTextarea">Description</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 
  <?php
  if(isset($_SESSION['status']) && $_SESSION['status_code']){
    ?>
    <script>
      swal({
        title: "Done!",
        text: "<?php echo $_SESSION['status']; ?>",
        icon: "<?php echo $_SESSION['status_code']; ?>",
        button: "Okay ",
      }).then(function() {
    window.location = "index.php";
});
      </script>
      <?php
  }
  ?>

  <div class="container my-4 alert alert-success" role="alert">
    <h2>Add a Note</h2>
    <hr>
    <form action="index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Note Description</label>
        <div class="form-floating">
          <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea des"
            name="des"></textarea>
          <label for="floatingTextarea">Description</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <div class="container"style="width:100%;">

    <table class="table my-4" id="mytable">
      <thead class='table-primary'>
        <tr>
          <th scope="col">SN</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <?php
     $sql="SELECT * FROM `$username`";
     $result=mysqli_query($conn,$sql);
     $num= mysqli_num_rows($result);
     $counter=1;
     while($row=mysqli_fetch_assoc($result))
     {
       echo"
       <tr>
       <th scope='col'>".$counter."</th>
       <td scope='col'>".$row['title']."</td>
       <td scope='col'>".$row['des']."</td>
         <td scope='col'>"."<button class='btn btn-sm btn-primary edit' id=".$row['sn'].">Edit</button>  "."  <form style='display: inline-block;, padding=4px;' action='index.php' method='POST' class='my-2'>
         <input type='hidden' name='snodelete' value=".$row['sn'].">
         <input class='btn btn-sm btn-primary' name='delete' type='submit' value='Delete'></input>
         </form>"."</td>
         </tr>";
         $counter++;
        }
        ?>
      <tbody>
      </tbody>
    </table>
    <hr>
  </div>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((elements) => {
      elements.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleedit.value = title;
        descedit.value = description;
        snoedit.value = e.target.id;
        console.log(snoedit);
        $("#editModal").modal('toggle');

      })
    })
    </script>
<div class="card text-center">
  <div class="card-body">
    <h5 class="card-title alert-primary" role='alert'>Logout</h5>
    <p class="card-text">Are you sure you want to logout?</p>
    <a href="logoutconfirm.php" class="btn btn-primary">Logout</a>
  </div>
  <div class="card-footer text-muted">
   bNotes @ <?php echo $username; ?>
  </div>
</div>
<?php
require('footer.php');
?>
<hr>
<hr>
<hr>
<hr>

</body>
</html>