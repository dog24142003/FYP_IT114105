<?php
require_once('Common/header.php');
$tEmail = $_SESSION['Email'];
$tutorID = $_SESSION['TutorID'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/owl.theme.default.min.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/style.css" />

    <!-- timepicker css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"
    />
    <link
      rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css"
    />
    <title>Prixima BS5 Template</title>
    <style>
      body {
        font-family: Arial, Helvetica, sans-serif;
      }

      input {
        width: 300px;
        padding: 7px;
      }

      .ui-state-highlight {
        border: 0 !important;
      }

      .ui-state-highlight a {
        background: #363636 !important;
        color: #fff !important;
      }
    </style>
  </head>

  <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
  

    <section id="HereIsMain" class="text-center">
      <div class="bg-warning">
        <div class="container">
          <h2 class="text-start">Make your Course</h2>
        </div>
      </div>

      <form
        action="createCourse_sql.php"
        id="CreCourseFm"
        method="post"
        enctype="multipart/form-data"
      >
        <div class="container">
          <div class="row p-2 mb-3">
            <div class="col">
              <div class="row p-2 border">
                <div class="row">Course Name :</div>

                <div class="row">
                  <input
                    type="text"
                    name="courseName"
                    class="form-control"
                    required
                  />
                </div>

                <div class="row">Price :</div>

                <div class="row">
                  <input
                    type="number"
                    name="coursePrice"
                    class="form-control"
                    min="0"
                    required
                  />
                </div>

                <div class="row">Your Course Subject :</div>

                <div class="row">
                  <select
                    name="courseSubject"
                    class="form-select form-select-lg mb-3 form-control"
                    aria-label=".form-select-lg example"
                    required
                  >
                    <option disabled selected>
                      Select the subject of your course
                    </option>
                    <option value="chinese">Chinese</option>
                    <option value="english">English</option>
                    <option value="math">math</option>
                    <option value="generalEducation">General Education</option>
                    <option value="m1">M1</option>
                    <option value="m2">M2</option>
                    <option value="biology">Biology</option>
                    <option value="chemistry">Chemistry</option>
                    <option value="physics">Physics</option>
                    <option value="chineseHistory">Chinese History</option>
                    <option value="history">History</option>
                    <option value="bafs">BAFS</option>
                    <option value="geography">Geography</option>
                    <option value="economic">Economic</option>
                    <option value="visualArt">Visual Art</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col border">
              <div class="row p-2">
                <div class="row">Course Description :</div>

                <div class="border border-dark h-auto">
                  <div class="form-outline ">
                    <textarea
                      class="form-control"
                      form="CreCourseFm"
                      name="courseDetails"
                      id="textAreaExample5"
                      rows="7"
                    >
Enter the Course Description in here.
                    </textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col m-2">
              <div class="row bg-warning text-dark rounded-pill">
                <p class="h5">Date</p>
              </div>

              <div class="row border text-start p-2 mt-2">

                <div class="row">Choose Date :</div>

                <div class="row">
                  <input
                    type="text"
                    name="datePick"
                    id="datePick"
                    class="form-control"
                    required
                  />
                </div>
              </div>
            </div>

            <div class="col m-2">
              <div class="row bg-warning text-dark rounded-pill">
                <p class="h5">Time</p>
              </div>

              <div class="row border text-start p-2 mt-2" style="height: 10rem">
                <div>
                  <div class="row">Start Time :</div>
                  <input
                    type="text"
                    name="courseTime"
                    id="time"
                    class="form-control"
                    min="0"
                    required
                  />
                </div>

                <div>
                  <div class="row">Hour :</div>
                  <input
                    type="number"
                    name="hour"
                    class="form-control"
                    min="1"
                    required
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="row m-4">
            <div class="col">
              <a class="btn btn-secondary" id="Btn_cancel" onclick="location.href='page_teacher_profile.php';">Cancel</a>
            </div>
            <div class="col">
              <input type="hidden" name="tutorID" id="tutorID" value="<?php echo $tutorID ?>" />
              <input
                class="btn btn-warning"
                type="submit"
                name="craeteCourseSubmit"
                value="Create"
              />
            </div>
          </div>
        </div>
      </form>
    </section>

    <!-- get file type when user uploaded the fle -->

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/app.js"></script>
    <!-- timepicker -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/dubrox/Multiple-Dates-Picker-for-jQuery-UI@master/jquery-ui.multidatespicker.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#datePick").multiDatesPicker({
          minDate: "0",
          dateFormat: "yy-mm-dd",
          // maxPicks: 2,
        });
        $("#time").timepicker({
          timeFormat: "HH:mm",
          interval: 60,
          //   minTime: "24",
          //   maxTime: "12:00pm",
          defaultTime: "11",
          //   startTime: "00:00",
          dynamic: false,
          dropdown: true,
          scrollbar: true,
        });
      });
    </script>
  </body>
</html>
