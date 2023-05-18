<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/Common/header_abosulte.php");

$conn = getDBconn();

if (isset($_POST['Edit_Notes'])) {
  header("location:viewNotesList.php");
}

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>Prixima BS5 Template</title>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
  <?php

  $sql = "SELECT notes.*,Tutor.FirstName,Tutor.LastName,Tutor.TutorID FROM notes,Tutor WHERE NotesID = " . $_POST['notesID'] . " AND tutor.TutorID = notes.TutorID;";

  $result = $conn->query($sql);
  $num = mysqli_num_rows($result);

  if ($num >= 1) {

    $rs = mysqli_fetch_assoc($result);
  } else {
    echo '<script>alert("This Notes had not found.")</script>';
    echo '<script type="text/javascript"> window.location.replace("../../index.php"); </script>';
  }

  extract($rs);
  ?>

  <section id="HereIsMain" class="text-center">
    <div class="container">
      <form action="doEditNotes.php" method="post" enctype="multipart/form-data">
        <div class="row mb-5">
          <div class="col-8">

            <?php
            echo '<img id="ImgPreView" src="data:image/' . $ImgType . ';base64,' . base64_encode($Img) . '" class="border"
                  style="object-fit: scale-down; height: 30rem"  object-fit: scale-down;" alt=""/>';
            ?>
          </div>

          <div class="col-4 p-2">
            <div name="subject" class="bg-warning text-dark h4 rounded-pill">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text bg-warning" for="inputGroupSelect01">Subject</label>
                </div>
                <select name="notesSubject" class="custom-select bg-warning" id="inputGroupSelect01">

                  <?php
                  $OptionArray = array(
                    "Chinese",
                    "English",
                    "math",
                    "GeneralEducation",
                    "M1",
                    "M2",
                    "Biology",
                    "Chemistry",
                    "Physics",
                    "ChineseHistory",
                    "History",
                    "Bafs",
                    "Geography",
                    "Economic",
                    "VisualArt"
                  );

                  foreach ($OptionArray as $Option) {
                  ?>

                    <option value="<?php echo $Option ?>" <?php if ($Option == $Subject) : ?> selected="selected" <?php
                                                                                                                endif; ?>><?php echo $Option ?></option>

                  <?php
                  }
                  ?>

                </select>
              </div>
            </div>
            <div class="h3 text-start bg-light text-dark rounded-pill">
              Notes Name:
            </div>
            <div class="h4 text-break text-start" style="height: 30%">
              <input type="text" name="notesName" class="form-control" value="<?php echo $Name ?>" />
            </div>
            <div class="h4 text-start bg-light text-dark rounded-pill">
              author :
            </div>
            <div name="tutorName" class="h4 text-start" style="height: 15%">
              <?php echo $FirstName . ", " . $LastName ?>
            </div>

            <div class="h4 text-start bg-light text-dark rounded-pill">
              Price
            </div>

            <div name="BookPrice" class="h4 text-start text-info row">
              <div class="col-1">$</div>
              <div class="col-11">
                <input name="notesPrice" min="0" type="number" class="form-control" value="<?php echo $Price ?>" />
              </div>

            </div>
          </div>
        </div>

        <div class="row mb-3 p-2">
          <!-- CoverImgInput -->
          <div class="col m-1 rounded-pill">
            <div class="row">
              <div class="h3 bg-warning  rounded-pill">Input New Notes Cover <i class="fa-solid fa-image text-dark"></i>
              </div>
              <div class="h4" style="height: 3rem;">
                The Image will preview after uploaded.
              </div>
            </div>
            <div class="row">
              <input type="file" id="CoverImgUploader" class="form-control" name="CoverImgUploader" accept=".png, .jpg, .jpeg" onchange="loadFile(event)" />
            </div>
          </div>

          <div class="col m-1">
            <div class="row">
              <div class="h3 bg-warning rounded rounded-pill">Input New Notes PDF file <i class="fa-regular fa-file-pdf text-dark"></i></div>
              <div class="h4 " style="height: 3rem;">The original PDF file :
                <?php echo '<a href="data:application/pdf;base64,' . base64_encode($PDF) . '" class= "btn btn-secondary rounded-pill" download >Download Notes</a>' ?>
              </div>
            </div>
            <div class="row">
              <input type="file" class="form-control" name="pdfUploader" accept="application/pdf" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="row">
            <h2 class="text-start bg-warning rounded-pill">Details</h2>
          </div>

          <div class="row text-start">
            <textarea class="" id="w3review" style="height: 35rem;" name="notesDetail" rows="4" cols="50"> <?php echo $Detail ?> </textarea>
          </div>

        </div>

        <div class="row d-flex justify-content-center">
          <div class="col-2 p-2">
            <a href="../notes/viewBookDetails.php?notesId=<?php echo $_POST['notesID']; ?>" class="btn btn-secondary" style="width: 10rem ;">Cancel</a>
          </div>

          <div class="col-2 p-2">
            <input type="reset" class="btn btn-primary" value="Reset">

          </div>

          <div class="col-2 p-2">
            <input type="hidden" name="ImgType" value="">
            <input type="hidden" name="notesID" value="<?php echo $_POST['notesID']; ?>" />
            <input type="hidden" name="HasEditSubmit" value="Yes" />
            <input type="button" id="editNotesFM" name="editNotesFM" class="btn btn-warning" style="width: 10rem ;" value="Confirm_Edit" />
          </div>

        </div>

      </form>
    </div>
  </section>

  <script>
    let file = document.getElementById("CoverImgUploader");

    file.addEventListener("input", () => {
      if (file.files.length) {
        let fileExtension = file.files[0].name.split(".").pop()
        document.getElementById("ImgType").value = fileExtension;
      }
    })

    var loadFile = function(event) {
      var image = document.getElementById('ImgPreView');
      image.src = URL.createObjectURL(event.target.files[0]);
    };

    $('#editNotesFM').on('click', function() {

      let $form = $(this).closest('form');

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success m-3',
          cancelButton: 'btn btn-danger m-3'
        },
        buttonsStyling: false,
      })

      swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, edit it!'
      }).then((result) => {
        if (result.value) {
          $form.submit();
        }
      });
    });
  </script>

  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../js/owl.carousel.min.js"></script>
  <script src="../../js/app.js"></script>
</body>

</html>