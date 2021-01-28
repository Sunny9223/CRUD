<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "notes";
  $conn = mysqli_connect($servername, $username, $password, $database);
  $connection = false;
  if (!$conn) {
    $connection = true;
  }
?>
<?php
  $insert = false;
  $edit = false;  
  $delete = false;
  $entryError = false;
  // // if (empty($_POST['title'])) {
  //   echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  //   <strong>Error!</strong> We are facing some technical issues.
  //   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  //     <span aria-hidden="true">&times;</span>
  //   </button>
  // </div>';
  // }
  if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $delete = mysqli_query($conn, $sql);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $entryError = false;
    $delete = false;
    if (isset($_POST['snoEdit'])) {
      $sno = $_POST['snoEdit'];
      $title = $_POST['titleEdit'];
      $description = $_POST['descriptionEdit'];
      $sql = "UPDATE `notes` SET `title`='$title',`description`='$description' WHERE `notes`.`sno`=$sno;";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $edit = true;
      }
      else {
        echo "Error";
      }
    }
    else {
    if (!empty($_POST['title'] && $_POST['description'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "INSERT INTO `notes`(`title`, `description`) VALUES ('$title','$description')"; 
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $insert = true;
    }
  }
  else {
    $entryError = true;
  }
}
  }
  ?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <title>Notes!</title>
</head>

<body>
  <!--modal-->
  <!-- Button trigger modal -->
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Notes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="post">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="exampleInputEmail1">Title of the Notes</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Description of the Notes</label>
              <input type="text" class="form-control" id="descriptionEdit" name="descriptionEdit">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
          </form>

        </div>
      </div>
    </div>
  </div>
  <!--modal-->
  <!--navbar-->
  <?php include "_navbar.php"; ?>
  <!--navbar-->
  <!--PHP-->
  <?php
    if ($connection) {
      die('<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> We are facing some technical issues.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>');
    }
    if ($insert) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You had added the notes successfully.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    if ($edit) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Edited successfully.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    if ($entryError) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Please enter the required fields.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    if ($delete) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You deleted the record successfully.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
  ?>

  <!--PHP-->
  <!--Forms-->
  <div class="container my-4">
    <h1>Enter the Notes here</h1>
    <form action="index.php" method="post">
      <div class="form-group">
        <label for="exampleInputEmail1">Title of the Notes</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Description of the Notes</label>
        <input type="text" class="form-control" id="description" name="description">
      </div>
      <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
  </div>
  <!--Forms-->
  <!--Table-->
  <div class="container">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No.</th>
          <th scope="col">Title of the Notes</th>
          <th scope="col">Description of the Notes</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
      $sql = "SELECT * FROM `notes`";
      $result = mysqli_query($conn, $sql);
      $sno = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $sno = $sno + 1;
      echo '<tr>
      <th scope="row">'.$sno.'  </th>
      <td>'.$row['title'].'</td>
      <td>'.$row['description'].'</td>
      <td><button class="btn btn-success btn-sm my-2 my-sm-0 edit" type="submit" id="'.$row['sno'].'">Edit</button><button class="btn btn-sm btn-danger my-2 mx-1 my-sm-0 delete" type="submit" id="d'.$row['sno'].'">Delete</button>
      </td>
    </tr>'; 
      }
    ?>
      </tbody>
    </table>
  </div>
  <!--Table-->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Edit");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title);
        console.log(description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      });
    });
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
      element.addEventListener("click", (e) =>{
        console.log("delete", e);
        sno = e.target.id.substr(1,);
        if (confirm("Are you sure to delete this note?")) {
          window.location = `index.php?delete=${sno}`;
        }
        else{
          console.log("no");
        }
      })
    });
  </script>
</body>

</html>