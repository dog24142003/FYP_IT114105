<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/Common/header_abosulte.php");

$conn = mysqli_connect("localhost", "root", "", "tutorcatdb");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['TutorID'])) {
  echo '<script>alert("Login First!")</script>';
  echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
} else {
  $TutorID = $_SESSION['TutorID'];
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
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>Prixima BS5 Template</title>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
  <!-- BOTTOM NAV -->

  <section id="HereIsMain" class="text-center">
    <div class="bg-warning">
      <div class="container">
        <h2 class="text-start">Make you Notes</h2>
      </div>
    </div>

    <form action="doCreateNt.php" id="CreNotesFm" method="post" enctype="multipart/form-data">
      <div class="container">
        <div class="row p-2 mb-3">
          <div class="col">
            <div class="row p-2 border">
              <div class="row">Notes Name :</div>

              <div class="row">
                <input type="text" name="notesName" value="" class="form-control" required />
              </div>

              <div class="row">Price :</div>

              <div class="row">
                <input type="number" name="notesPrice" class="form-control" min="0" required />
              </div>

              <div class="row">Your Notes Subject :</div>

              <div class="row">
                <select name="notesSubject" class="form-select form-select-lg mb-3 form-control" aria-label=".form-select-lg example" required>
                  <option disabled selected>
                    Select the subject of your notes
                  </option>
                  <option value="Chinese">Chinese</option>
                  <option value="English">English</option>
                  <option value="Math">math</option>
                  <option value="GeneralEducation">General Education</option>
                  <option value="M1">M1</option>
                  <option value="M2">M2</option>
                  <option value="Biology">Biology</option>
                  <option value="Chemistry">Chemistry</option>
                  <option value="Physics">Physics</option>
                  <option value="ChineseHistory">Chinese History</option>
                  <option value="History">History</option>
                  <option value="Bafs">BAFS</option>
                  <option value="Geography">Geography</option>
                  <option value="Economic">Economic</option>
                  <option value="VisualArt">Visual Art</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col border">
            <div class="row p-2">
              <div class="row">Notes Detail :</div>

              <div class="border border-dark h-auto">
                <div class="form-outline w-100 h-100">
                  <textarea class="form-control" form="CreNotesFm" name="notesDetails" id="textAreaExample5" rows="7">Enter the Notes Details in here.
                    </textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col m-2">
            <div class="row bg-warning text-dark rounded-pill">
              <p class="h5">Upload Notes Cover</p>
            </div>
            <div class="row p-2 border mt-2" style="height: 10rem;">

              <input type="file" id="CoverImg" name="CoverImg" accept=".png, .jpg, .jpeg" onchange="loadFile(event)" required />
              <input type="hidden" id="ImgType" name="ImgType" value="" />
              <p class="mb-0 text-start">Only accept image type : png , jpg , jpeg </p>
              <p class="text-start">The image size : smaller than 50M. </p>
              <script>
                let file = document.getElementById("CoverImg");

                file.addEventListener("input", () => {
                  if (file.files.length) {
                    let fileExtension = file.files[0].name.split(".").pop()
                    document.getElementById("ImgType").value = fileExtension;
                  }
                })

                var loadFile = function(event) {
                  var image = document.getElementById('output');
                  image.src = URL.createObjectURL(event.target.files[0]);
                };
              </script>

            </div>

            <div class="row p-2 border">
              <div class="border">
                <p><img id="output" width="10rem" style="object-fit: scale-down;" /> preview After uploaded image</p>

              </div>
            </div>

          </div>
          <div class="col m-2">
            <div class="row bg-warning text-dark rounded-pill">
              <p class="h5">Upload Notes File</p>
            </div>

            <div class="row border text-start p-2  mt-2" style="height: 10rem;">
              <div>
                <input type="file" name="pdfUploader" accept="application/pdf" required />
              </div>

              <div>
                <p class=" text-start">The file size : smaller than 16MB . </p>
              </div>
            </div>


          </div>
        </div>

        <div class="row m-4">
          <div class="col">
            <Button class="btn btn-secondary" id="Btn_cancel">Cancel</Button>
          </div>
          <div class="col">
            <input type="hidden" name="craeteNotesSubmit" value="Yes">
            <input class="btn btn-warning" id="comfrimBtn" type="button" name="comfrimBtn" value="Create">
          </div>
        </div>

      </div>



    </form>
  </section>

  <script>
    $('#comfrimBtn').on('click', function() {

      let $form = $(this).closest('form');

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success m-3',
          cancelButton: 'btn btn-danger m-3'
        },
        buttonsStyling: false,
      });

      if ($('#CreNotesFm')[0].checkValidity()) {
        swalWithBootstrapButtons.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Create it!'
        }).then((result) => {
          if (result.value) {
            $form.submit();
          }
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'you missing some Infomation for the new notes!'
        })
      }
    });
  </script>

  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../js/owl.carousel.min.js"></script>
  <script src="../../js/app.js"></script>
</body>

</html>