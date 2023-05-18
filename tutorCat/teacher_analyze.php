<?php
require_once "conn.php";
require_once('common/header.php');
$tutorID = $_SESSION['TutorID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- Teacher List -->
    <link rel="stylesheet" href="css/teacher_analyze.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
    <!--   Required js-->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/app.js"></script>
    <!-- line chart -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
    <script>
        $(document).ready(function() {
            $("#myChart2").hide();
            $("#total").hide();

            $("#CA_btn").click(function() {
                /*hide*/
                $("#myChart2").hide();
                $("#total").hide();
                /*show*/
                $("#myChart").show();
                $("#total2").show();
                $("#total3").show();
            });
            $("#PA_btn").click(function() {
                /*hide*/
                $("#myChart").hide();
                $("#total2").hide();
                $("#total3").hide();
                /*show*/
                $("#myChart2").show();
                $("#total").show();
            });


        });

    </script>
</head>

<body>
    <br>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="col-sm-12 btn-group me-2">
            <button type="button" class="btn  btn-outline-warning" onclick="location.href='teacher_schedule.php';">Calendar</button>
            <button type="button" class="btn  btn-outline-warning" onclick="location.href='teacher_manageCourse.php';">Course Detail</button>
            <button type="button" class="btn  btn-outline-warning" onclick="location.href='teacher_analyze.php';">Analyze Report</button>
        </div>
    </div>




    <?php
    $conn = getDBconn();
    $sql = "SELECT COUNT(schedule.ScheduleID) AS orders, SUM(course.Cost) AS sales, MONTH(schedule.Date) AS  month FROM schedule, course WHERE schedule.CourseID= course.CourseID AND schedule.StudentID IS NOT NULL AND schedule.TutorID=" . $tutorID . " GROUP BY month;";
    $result = $conn->query($sql);
    $num = mysqli_num_rows($result);

    if ($num >= 1) {

        $conn->close();
        $mOrders = array();
        $month = array();
        $orders = array();
        $sales = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mOrders[] = array($row['month'] => $row['orders']);
            $month[] = $row['month'];
            $orders[] = $row['orders'];
            $sales[] = $row['sales'];
        }
    }

    $sql="SELECT SUM(TotalPrice) AS TP FROM broughtcourse WHERE TutorID = " . $tutorID . ";";

    $result1 = mysqli_query(getDBconn(), $sql);
    if ($result1->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $totalPrice = $row['TP'];
        }
    
    } else {
        echo "Error";
    }

    $sql="SELECT COUNT(schedule.ScheduleID) AS TC FROM schedule WHERE TutorID = " . $tutorID . " AND schedule.StudentID IS NOT NULL;";

    $result1 = mysqli_query(getDBconn(), $sql);
    if ($result1->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $totalCourse = $row['TC'];
        }
    
    } else {
        echo "Error";
    }
    $sql="SELECT SUM(course.Hour) AS TH FROM schedule,course WHERE schedule.CourseID = course.CourseID AND schedule.TutorID = " . $tutorID . " AND schedule.StudentID IS NOT NULL;";

    $result1 = mysqli_query(getDBconn(), $sql);
    if ($result1->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $totalHour = $row['TH'];
        }
    
    } else {
        echo "Error";
    }
    ?>
    <div id="Chart" class="col-sm-12  ">
        <div>
        <div class="h1">Tutor Analyze</div>
        <div class="text-right"><button id="CA_btn" class="btn btn-secondary btn-sm">Course Analyze</button>
        <button id="PA_btn" class="btn btn-secondary btn-sm">Profit Analyze</button></div>
        </div>
        <br>
        <div id="total">
        <div style="">
        <table class="table" style="width: 800px; float:right;">
  <thead>
    <tr>
      <th scope="col">Course ID</th>
      <th scope="col">Name</th>
      <th scope="col">Total Price</th>
      <th scope="col">Lessons</th>
    </tr>
  </thead>
  <tbody>
  <?php $conn = getDBconn();

$sql = "SELECT  Course.CourseID, Course.CName,broughtcourse.TotalPrice, Course.NoOfClass FROM course, broughtcourse WHERE course.CourseID = broughtcourse.CourseID AND course.TutorID=" . $tutorID . " ORDER BY TotalPrice DESC";
// $sql = "SELECT schedule.*, student.FirstName, student.LastName FROM schedule, student WHERE student.StudentID = schedule.StudentID AND schedule.StudentID IS NOT NULL AND TutorID= 10003 ORDER BY Date ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);


if ($num >= 1) {

    $conn->close();

    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
        $courseID = $row['CourseID'];
    }
    $i = 0;
    foreach ($results as $key => $result) {


        echo '  
        <tr>
        <th scope="row">'.$result['CourseID'].'</th>
        <td>'.$result['CName'].'</td>
        <td>'.$result['TotalPrice'].'</td>
        <td>'.$result['NoOfClass'].'</td>
      </tr>';
      if ($i++ == 2) break;
    }
} else {
    echo "<tr><td colspan='6' class='h1'>No Course Record</tr></td>";
}

?>

   
  </tbody>
</table>
        </div>
        <div  class="card rounded-circle border-5 border-info" style="width: 12rem;">
            <div class="card-body">
                <br>
                <h5 class="card-title text-center">Total Profit</h5>
               
                <p class="card-text">
                <h1 class="text-center">$<?php echo $totalPrice; ?></h1>
                </p>

            </div>
            
        </div>

        </div>
        
        <div></div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm d-flex">
        <div id="total2" class="card rounded-circle border-5 border-info" style="width: 12rem;">
            <div class="card-body">
                <br>
                <h5 class="card-title text-center">Total Course</h5>
                <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                <p class="card-text">
                <h1 class="text-center"><?php echo $totalCourse; ?></h1>
                </p>

            </div>
        </div>
        <div id="total3" class="card rounded-circle border-5 border-danger" style="width: 12rem;">
            <div class="card-body">
                <br>
                <h5 class="card-title text-center">Total Hours</h5>
                <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                <p class="card-text">
                <h1 class="text-center"><?php echo $totalHour ; ?>/hrs</h1>
                </p>

            </div>
        </div>
        </div></div></div>
        <canvas id="myChart" style=""></canvas>
        <canvas id="myChart2" style="margin-top:80px;"></canvas>
    </div>
    <script type="text/javascript">
        let orders = <?php echo json_encode($orders); ?>;
        let sales = <?php echo json_encode($sales); ?>;
        let month = <?php echo json_encode($month); ?>;

        function toMonthName(month) {
            const date = new Date();
            date.setMonth(month - 1);
            return date.toLocaleString('en-US', {
                month: 'long',
            });
        }

        for (let index = 0; index < month.length; index++) {
            month[index] = toMonthName(month[index]);
        }
    </script>
    <script>
        let chart = new Chart("myChart", {
            type: "line",
            data: {
                labels: month,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: orders
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Course per month'
                        },
                        ticks: {
                            stepSize: 1,
                            min: 0
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }]
                },
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Course Ananlyze Report'
                },
            }
        });
    </script>
    <script>
        let chart2 = new Chart("myChart2", {
            type: "line",
            data: {
                labels: month,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: sales
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Profit per month'
                        },
                        ticks: {
                            stepSize: 500,
                            min: 0
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }]
                },
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Profit Ananlyze Report '
                },
            }
        });
    </script>
</body>

</html>