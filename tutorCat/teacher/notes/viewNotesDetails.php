<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/Common/header_abosulte.php");

$conn = getDBconn();

if (isset($_SESSION['StudentID']) && !isset($_SESSION['TutorID'])) {
    $StudentID = $_SESSION['StudentID'];
} else {
    echo '<script>alert("You are not student.")</script>';
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="../../css/owl.theme.default.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../../css/style.css"/>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Prixima BS5 Template</title>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">


<?php
$sql = "SELECT notes.*,tutor.FirstName,tutor.LastName,tutor.TutorID FROM notes,tutor 
          WHERE notes.TutorID = tutor.TutorID
          AND NotesID = " . $_GET['notesId'];

$result = $conn->query($sql);
$num = mysqli_num_rows($result);

if ($num >= 1) {

    $rs = mysqli_fetch_assoc($result);
} else {
    echo '<script>alert("This Notes had not found.")</script>';
    echo '<script type="text/javascript"> window.location.replace("../../index.php"); </script>';
}

// if ($rs >= 1) {
//   extract($rs);
// } else {
//   echo '<script>alert("Book Cannot find!")</script>';
// }

extract($rs);

if (!isset($_SESSION['TutorID'])) {
    echo '<script>alert("You have not permission to do this.")</script>';
    echo '<script type="text/javascript"> window.location.replace("../../index.php"); </script>';
} else if (!$_SESSION['TutorID'] == $TutorID) {
    echo '<script>alert("You have not permission to do this.")</script>';
    echo '<script type="text/javascript"> window.location.replace("../../index.php"); </script>';
}

?>


<!-- BOTTOM NAV -->

<section id="HereIsMain" class="text-center">
    <div class="container">
        <div class="row mb-5">
            <div class="col-8">
                <?php
                echo '<img src="data:image/' . $ImgType . ';base64,' . base64_encode($Img) . '"class="border"
            style="object-fit: contain; height: 35rem" />';
                ?>
                <div name="notesName"></div>
            </div>

            <div class="col-4 p-2">
                <div name="subject" class="bg-warning text-dark h4 rounded-pill">
                    <?php echo $Subject ?>
                </div>
                <div class="h3 text-start text-dark rounded-pill p-2 bg-light">
                    Notes Name:
                </div>
                <div name="notesName" class="h3 text-break text-start" style="height: 15%">
                    <?php echo $Name ?>
                </div>
                <div class="h4 text-start bg-light text-dark rounded-pill p-2">
                    author :
                </div>
                <div name="tutorName" class="h4 text-start" style="height: 15%">
                    <?php echo $FirstName . ", " . $LastName ?>
                </div>

                <div class="h4 text-start bg-light text-dark rounded-pill p-2">
                    Price :
                </div>

                <div name="NotesPrice" class="h4 text-start text-info">
                    $
                    <?php echo $Price ?>
                </div>

                <div class="row text-center p-2 d-flex justify-content-center mb-3">


                </div>

                <div class="row">
                    <div class="col">
                        <form action="doDelNotes.php" method="post">
                            <input type="hidden" name="notesID" value="<?php echo $_GET['notesId'] ?>">
                            <input type="hidden" name="delnotesFm" value="Yes">
                            <input type="button" id="delNotesBtn" class="btn btn-danger" value="Delete"/>
                        </form>
                    </div>

                    <div class="col">
                        <?php
                        echo '<a href="data:application/pdf;base64,' . base64_encode($PDF) . '" class= "btn btn-secondary" download >Download</a>';
                        ?>
                    </div>

                    <div class="col">
                        <form action="editNotes.php" class="d-inline" method="post">
                            <input type="hidden" name="notesID" value="<?php echo $_GET['notesId'] ?>">
                            <input type="submit" class="btn btn-warning" name="DeleteNotes" value="Edit"/>
                        </form>
                    </div>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="row border">
                <h2 class="text-start">Details</h2>
            </div>

            <div class="row border text-start">
                <pre class="text-start" style="white-space: pre-wrap;"><?php echo $Detail ?></pre>
            </div>
        </div>
    </div>
</section>

<script>

    $('#delNotesBtn').on('click', function () {

        let $form = $(this).closest('form');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success m-3',
                cancelButton: 'btn btn-danger m-3'
            },
            buttonsStyling: false,
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure to delete this notes?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
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