<?php
require_once "conn.php";
require_once('Common/header.php');
$tutorID = $_SESSION['TutorID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/student_schedule.css" />
    <title>Document</title>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
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
    <div id='calendar'></div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                <?php
                $conn = getDBconn();

                $sql = "SELECT course.CName, schedule.Date, course.Time, course.Hour FROM schedule, course WHERE StudentID=" . $tutorID . " AND course.courseID = schedule.courseID";

                $result = $conn->query($sql);
                $num = mysqli_num_rows($result);
                if ($num >= 1) {
                    // extract(mysqli_fetch_assoc($result));
                    // mysqli_free_result($result);
                    $conn->close();

                    while ($row = mysqli_fetch_assoc($result)) {
                        $results[] = $row;
                    }
                    foreach ($results as $key => $result) {
                        $endTime  = date("H:i:s", strtotime($result['Time'] . ' + ' . $result['Hour'] . ' hours'));

                        echo '{
                                        title: "' . $result['CName'] . '",
                                        start: "' . $result['Date'] . 'T' . $result['Time'] . '",
                                        end: "' . $result['Date'] . 'T' . $endTime . '"
                                    },';
                    }
                }
                ?>


            ],

            eventClick: function(info) {
                var date = info.event.start;
                const formatedDate = formatDate(date);

                // window.location.href = `student_course_detail.php? date=${formatedDate}`;


            }
        });

        calendar.render();
    });

    function formatDate(date) {
        var d = new Date(date)
        let day = d.getDate();
        let month = d.getMonth() + 1;
        let year = d.getFullYear();
        if (month < 10)
            month = "0" + month;
        if (day < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
</script>

</html>