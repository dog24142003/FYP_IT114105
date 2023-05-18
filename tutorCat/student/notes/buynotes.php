<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/Common/header_abosulte.php");

$conn = mysqli_connect("localhost", "root", "", "tutorcatdb");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['StudentID'])) {
  echo '<script>alert("Login First!")</script>';
  echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
}

$studentID = $_SESSION['StudentID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/x-icon" href="favicon.ico" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/owl.carousel.min.css" />
  <link rel="stylesheet" href="../../css/owl.theme.default.min.css" />
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../css/style.css" />
  <title>Prixima BS5 Template</title>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
  <?php


  $conn = mysqli_connect("localhost", "root", "", "tutorcatdb");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }


  $sql = "SELECT * FROM notes,tutor
  WHERE NotesID = " . $_POST['notesId'] . "
  AND notes.TutorID = tutor.TutorID;";

  $result = $conn->query($sql);

  $num = mysqli_num_rows($result);

  if ($num >= 1) {

    $rs = mysqli_fetch_assoc($result);
  } else {
    echo '<script>alert("This notes had not found.")</script>';
    echo '<script type="text/javascript"> window.location.replace("../../index.html"); </script>';
  }

  mysqli_free_result($result);
  $notes_NotesID = $rs['NotesID'];
  $notes_Name = $rs['Name'];
  $notes_Price = $rs['Price'];
  $notes_ImgType = $rs['ImgType'];
  $notes_Img = $rs['Img'];
  $notes_Subject = $rs['Subject'];
  $author_FirstName = $rs['FirstName'];
  $author_LastName = $rs['LastName'];
  ?>

  <!-- BOTTOM NAV -->


  <section id="HereIsMain" class="text-center">
    <div class="container">
      <!-- <?php
            echo $_POST['notesId'];
            echo $_POST['tutorId'];
            ?> -->
      <div class="row mb-5">
        <div class="col-8">
          <?php
          echo '<img src="data:image/' . $notes_ImgType . ';base64,' . base64_encode($notes_Img) . '"class="border"
                style="object-fit: contain; height: 30rem" />';
          ?>
          <div name="notesName"></div>
        </div>

        <div class="col-4 p-2">
          <div name="suject" class="bg-warning text-dark h4 rounded-pill">
            <?php echo $notes_Subject ?>
          </div>
          <div class="h3 text-start bg-light text-dark rounded-pill">
            Notes Name:
          </div>
          <div name="notesName" class="h4 text-break text-start" style="height: 30%">
            <?php echo $notes_Name ?>
          </div>
          <div class="h4 text-start bg-light text-dark rounded-pill">
            author :
          </div>
          <div name="tutorName" class="h4 text-start" style="height: 15%">
            <?php echo $author_FirstName . "," . $author_LastName ?>
          </div>

          <div class="h4 text-start bg-light text-dark rounded-pill">
            Price :
          </div>

          <div name="BookPrice" class="h4 text-start text-info">
            $
            <?php echo $notes_Price; ?>
          </div>

        </div>

      </div>

      <div class="row mb-5">
        <div class="col h3 text-start text-primary">
          <?php

          $sql = "SELECT * FROM student WHERE StudentID = $studentID";

          $result = $conn->query($sql);

          $num = mysqli_num_rows($result);

          if ($num >= 1) {

            $rs = mysqli_fetch_assoc($result);
          } else {
            echo '<script>alert("This Notes had not found.")</script>';
            echo '<script type="text/javascript"> window.location.replace("../../index.html"); </script>';
          }

          mysqli_free_result($result);
          $stu_Point = $rs['Point'];
          $stu_studentID  = $rs['StudentID'];



//
//              <input type="hidden" name="studentId" value="' . $studentID . '"/>
//              <input type="hidden" name="notesId" value="' . $NotesID . '"/>
//              <input type="hidden" name="price" value="' . $price . '"/>

          ?>
        </div>
      </div>

      <div class="row mb-5">
        <div class="col">
          <a href="../../Common/notes/viewNotesDetails.php?notesId=<?php echo $_POST['notesId']; ?> " class="btn btn-secondary" style="width: 20rem;">Cancel</a>
        </div>

        <?php

          echo '<div class="col">
            <form method="post" action="../../payment/payment.php">
              <input type="hidden" name="studentId" value="' . $studentID . '"/>
              <input type="hidden" name="notesId" value="' . $notes_NotesID . '"/> 
              <input type="hidden" name="price" value="' . $notes_Price . '"/> 
              <input type="hidden" name="item" value="' . $notes_Name . '"/>
                                                                  
            <input type="submit" class="btn btn-warning" style="width: 20rem;" name="buyNotesFm" value="Comfrim">
            </form>
          </div>';

        ?>
      </div>



    </div>

  </section>

  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../js/owl.carousel.min.js"></script>
  <script src="../../js/app.js"></script>
</body>

</html>