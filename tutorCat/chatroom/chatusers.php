<?php
session_start();
require_once('../conn.php');

if ($_SESSION['account'] == 'Student') {
    $sql = "SELECT * FROM student WHERE StudentID = {$_SESSION['StudentID']}";
} else {
    $sql = "SELECT * FROM tutor WHERE TutorID = {$_SESSION['TutorID']}";
}

$rs = mysqli_query(getDBconn(), $sql);
$row = mysqli_fetch_array($rs);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/owl.carousel.min.css" />
    <link rel="stylesheet" href="../css/owl.theme.default.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" /
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/chatroom.css" />
    <link rel="stylesheet" href="../css/emoji.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Chat Room</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Tutor Cat<span class="dot">.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Course</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">NoteBook</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Profile</a>
                    </li>
                </ul>
                <?php
                if (isset($_SESSION['StudentID']) || isset($_SESSION['TutorID'])) {
                    echo '<a class="nav-link">Welcome ' . $_SESSION["FirstName"] . '<h5><strong><div onclick="point()"style="text-align:right; cursor: pointer;">' . $_SESSION["Point"] . ' Point</div></strong></h5></a>';
                    //echo '<a href="chatroom/chatusers.php" class="btn btn-brand ms-lg-3">Chat Room</a>';
                    echo '<a href="../logout.php" class="btn btn-brand ms-lg-3">Logout</a>';

                } else {
                    echo '<a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-brand ms-lg-3">Sign
                        up</a>';
                    echo '<a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal1"
                        class="btn btn-brand ms-lg-3">Login</a>';
                }
                ?>
            </div>
        </div>
    </nav>
    <main class="content">
        <div class="container p-0">
            <h1 class="h3 mb-3">Chat Room</h1>
            <input type="text" id="fromUser" value=<?php echo $_SESSION["UniqueID"] ?> hidden />
            <div class="card" style="height:800px">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-3 border-right">
                        <div class="px-4 d-none d-md-block">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control my-3" placeholder="Search..."
                                        id="live_search">
                                </div>
                            </div>
                        </div>
                        <div id="livesearchresult">
                            <?php
                            if ($_SESSION['account'] == 'Student') {
                                $sql = "SELECT * FROM tutor";
                            } else {
                                $sql = "SELECT * FROM student";
                            }
                            $msgs = mysqli_query(getDBConn(), $sql);
                            while ($msg = mysqli_fetch_assoc($msgs)) {
                                if ($msg["UniqueID"] == 0) {
                                    continue;
                                }
                                echo '<a href=?toUser=' . $msg["UniqueID"] . ' class="list-group-item list-group-item-action border-0">
                        <div class="d-flex align-items-start" onclick="myFunction()">
                            <div class="flex-grow-1 ml-3">
                            <strong>' . $msg["FirstName"] . ' ' . $msg["LastName"] . '</strong>
                                <div class="small"><i class="fa fa-circle" style="font-size:12px;color:green"></i> ' . $msg["Status"] . '</div>
                            </div>
                        </div>
                    </a>
                    <hr class="d-block d-lg-none mt-1 mb-0">';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7 col-xl-9">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <!-- <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                    class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40"> -->
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <?php
                                    if (isset($_GET["toUser"])) {
                                        if ($_SESSION['account'] == 'Student') {
                                            $sql = "SELECT * FROM tutor WHERE UniqueID = '" . $_GET["toUser"] . "'";
                                        } else {
                                            $sql = "SELECT * FROM student WHERE UniqueID = '" . $_GET["toUser"] . "'";
                                        }
                                        $userName = mysqli_query(getDBConn(), $sql);
                                        $uName = mysqli_fetch_assoc($userName);
                                        echo '<input type="text" value=' . $_GET["toUser"] . ' id="toUser" hidden/>';
                                        echo '<strong>' . $uName["FirstName"] . ' ' . $uName["LastName"] . '</strong>';
                                    } else {
                                        if ($_SESSION['account'] == 'Student') {
                                            $sql = "SELECT * FROM tutor";
                                        } else {
                                            $sql = "SELECT * FROM student";
                                        }
                                        $userName = mysqli_query(getDBConn(), $sql);
                                        $uName = mysqli_fetch_assoc($userName);
                                        $_SESSION["toUser"] = $uName["UniqueID"];
                                        echo '<input type="text" value=' . $_SESSION["toUser"] . ' id="toUser" hidden/>';
                                        //echo $uName["FirstName"];
                                        //echo "Select user to chat";
                                    }
                                    ?>
                                    <!-- <div class="text-muted small"><em>Typing...</em></div> -->
                                </div>
                                <?php
                                if (!isset($_GET["toUser"])) {
                                    echo '<div style="display: none;">';
                                } else {
                                    echo '<div>';
                                }
                                ?>

                                <button class="btn btn-primary btn-lg mr-1 px-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-phone feather-lg">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                        </path>
                                    </svg></button>
                                <button class="btn btn-info btn-lg mr-1 px-3 d-none d-md-inline-block"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-video feather-lg">
                                        <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                    </svg></button>
                                <button class="btn btn-light border btn-lg px-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-more-horizontal feather-lg">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg></button>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!isset($_GET["toUser"])) {
                        echo '<div class="position-relative" style="display: none;">';
                    } else {
                        echo '<div class="position-relative">';
                    }
                    ?>
                    <div class="chat-messages p-4" id="msgBody" style="height:655px">
                        <?php
                        if (isset($_GET["toUser"])) {
                            $chats = mysqli_query(getDBConn(), "SELECT * FROM messages where (FromUser = '" . $_SESSION["UniqueID"] . "' AND
                            ToUser = '" . $_GET["toUser"] . "') OR (FromUser = '" . $_GET["toUser"] . "' AND ToUser = '" . $_SESSION["UniqueID"] . "')");

                            while ($chat = mysqli_fetch_assoc($chats)) {
                                if ($chat["FromUser"] == $_SESSION["UniqueID"]) {
                                    echo "<div style='text-align:right;'>
                                        <p style='background-color:lightblue; word-wrap:break-word; display:inline-block;
                                            padding:5px; border-radius:10px; max width:70%;'>
                                            " . $chat["Msg"] . "
                                        </p>
                                        </div>";
                                } else {
                                    echo "<div style='text-align:left;'>
                                        <p style='background-color:yellow; word-wrap:break-word; display:inline-block;
                                            padding:5px; border-radius:10px; max width:70%;'>
                                            " . $chat["Msg"] . "
                                        </p>
                                        </div>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (!isset($_GET["toUser"])) {
                    echo '<h2>Select a user to start chat.</h2>';
                    echo '<div class="flex-grow-0 py-3 px-4 border-top" style="display: none;">';
                } else {
                    echo '<div class="flex-grow-0 py-3 px-4 border-top">';
                }
                ?>
                <div class="input-group">
                    <div class="upload" style="padding: 5px; cursor: pointer;">&#128193;</div>
                    <div class="emojikeyboard" style="padding: 5px; cursor: pointer;">&#128512;</div>
                    <input type="text" id="msg" class="form-control" placeholder="Type your message">
                    <button id="send" class="btn btn-primary">Send</button>
                </div>
                <div class="emojiPicker" style="display: none;">
                    <div class="emojis">
                        <div class="emojiFrame"><span class="emoji">&#128540;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128513;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128514;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128515;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128516;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128517;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128518;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128519;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128521;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128522;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128523;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128524;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128525;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128526;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128527;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128528;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128529;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128530;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128531;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128532;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128533;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128534;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128535;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128536;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128537;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128538;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128539;</span></div>
                        <div class="emojiFrame"><span class="emoji">&#128546;</span></div>
                    </div>
                </div>
                <div class="fileUpload" style="display: none; margin-top: 15px;">
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        Select file to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="hidden" name="fromUser" id="fromUser" value="<?php echo $_SESSION["UniqueID"]; ?>">
                        <input type="hidden" name="toUser" id="toUser" value="<?php echo $_GET["toUser"]; ?>">
                        <input type="submit" value="Send" name="submit">
                    </form>
                </div>
            </div>
    </main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#live_search").keyup(function() {
        var input = $(this).val();
        if (input != "") {
            $.ajax({
                url: "livesearch.php",
                method: "POST",
                data: {
                    input: input
                },

                success: function(data) {
                    $("#livesearchresult").html(data);
                }
            });
        }
    })
    $(".emojikeyboard").click(function() {
        $(".emojiPicker").toggle();
    })
    $(".upload").click(function() {
        $(".fileUpload").toggle();
    })

    $(".emoji").click(function() {
        // target, where emoji will be placed
        var msg = $("#msg");

        //emoji will be placed always at end of textbox
        msg.val(msg.val() + $(this).text());
    })

    $("#send").on("click", function() {
        if (document.getElementById("fileToUpload").files.length == 0) {
            if ($("#msg").val() != "") {
                $.ajax({
                    url: "insertMessage.php",
                    method: "POST",
                    data: {
                        toUser: $("#toUser").val(),
                        fromUser: $("#fromUser").val(),
                        msg: $("#msg").val(),
                        type: "text"
                    },
                    dataType: "text",
                    success: function(data) {
                        $("#msg").val("");
                    }
                });
            }
        } else {
            alert("file");
        }
    })

    setInterval(function() {
        $.ajax({
            url: "realTimeChat.php",
            method: "POST",
            data: {
                fromUser: $("#fromUser").val(),
                toUser: $("#toUser").val(),
            },
            dataType: "text",
            success: function(data) {
                $("#msgBody").html(data);
            }
        });

        var elem = document.getElementById('msgBody');
        elem.scrollTop = elem.scrollHeight;
    }, 500);
});
</script>
<script>
var input = document.getElementById("msg");

// Execute a function when the user presses a key on the keyboard
input.addEventListener("keypress", function(event) {
    // If the user presses the "Enter" key on the keyboard
    if (event.key === "Enter") {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        document.getElementById("send").click();
    }
});
</script>
<script type="application/javascript">
function point() {
    window.location.replace("../payment/example.php");
}
</script>

</html>