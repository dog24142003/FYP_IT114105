<?php

if (!isset($_GET['notesId'])) {
    echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bootstrap 5 Thank You Example</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="border border-3 border-warning"></div>
                <div class="card  bg-white shadow p-5">
                    <div class="mb-4 text-center">

                            <i class="fa-solid fa-cart-shopping text-warning display-1  p-4" style="width: 10rem;height: 10rem;"></i>
        
    
                    </div>
                    <div class="text-center">
                        <h1>Notes Bought!</h1>
                        <p></p>
                        <a class="btn btn-outline-warning" href="../../Common/notes/viewNotesDetails.php?notesId=<?php echo $_GET['notesId']; ?>">Back Notes Details</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/1aa2810eee.js" crossorigin="anonymous"></script>
    </body>

</html>