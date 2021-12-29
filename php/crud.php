<?php
  $insert = false;
  $update = false;
  $delete = false;

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "notes";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if(!$conn){
    echo "connection failed:".mysqli_connect_error();
  }
  // echo $_POST['snoEdit'];
  // echo $_SERVER['REQUEST_METHOD'];

  if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true; 
    $sql = "DELETE FROM `notes` WHERE `sno`=$sno";
    $result = mysqli_query($conn, $sql);
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['snoEdit'])){
      $sno = $_POST["snoEdit"];
      $title = $_POST["titleEdit"];
      $description = $_POST["descriptionEdit"];

      $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";

      $result = mysqli_query($conn, $sql);
      if($result){
        $update = true;
      }
    }
    else{ 

    $title=$_POST['title'];
    $description=$_POST['description'];

    $sql = "INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";

    $result = mysqli_query($conn, $sql);
    if($result){
      // echo "saved successfully";
      $insert=true;
    }
  }

  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   
    <title>PHP CRUD</title>
  </head>
  <body>
    

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
editModal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="crud.php" method="post">
      <div class="modal-body"> 
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="form-group mb-3 mt-3">
            <label for="title">Note Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
          </div>

          <div class="form-group mb-3">
            <label for="desc">Note Description</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
       </div>
       <div class="modal-footer d-block mr-auto">
         <button type="submit" class="btn btn-primary">Save changes</button>
         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       </div>
        </form>
      
    </div>
  </div>
</div>

<div class="container my-4">
    <?php
    if($insert){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your note has been successfully saved.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    ?>
    <?php
    if($update){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your note has been successfully updated.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    ?>
    <?php
    if($delete){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your note has been successfully deleted.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    ?>
      <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
         <?php
        $query = "SELECT * FROM notes";
        $result = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($result)){
          $sno+=1;
          echo "
        <tr>
          <th scope='row'>". $sno ."</th>
          <td>". $row['title'] ."</td>
          <td>". $row['description'] ."</td>
          <td><button class='edit btn btn-sm btn-info text-white' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger' id=d".$row['sno'].">Delete</button></td>
        </tr>";


        // echo $row['title']." ".$row['description'];
        } 
      ?>
      </tbody>
      </table>
    </div>

    <div class="container">
      <center><a href="../index.php" class="btn btn-warning m-5">back</a></center>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
      integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
      crossorigin="anonymous"
    ></script>

     <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          // console.log("button clicked",);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        });
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          // console.log("button clicked",);
          sno = e.target.id.substr(1,);

         if(confirm("Are you sure want to delete this record?")){
           console.log("yes")
           window.location = `create.php?delete=${sno}`;
         }
         else{
           console.log("No")
         }
        });
      })

      
    </script>
  </body>
</html>
