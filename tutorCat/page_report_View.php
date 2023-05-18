<?php require_once('Common/header.php');?>
    <?php
    require_once ("conn.php");
    $i=0;
    $senderEmail = $_GET['senderEmail'];
    $reportID = $_GET['reportID'];
//    $current_status = $_GET['report_status'];
    $sql = "SELECT * FROM reports WHERE reports.reportID = '$reportID' And senderEmail='$senderEmail ';";
    $result = mysqli_query(getDBconn(),$sql);
    
    if (!empty($result) && $result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $senderEmail = $row['senderEmail'];
            $getterEmail = $row['getterEmail'];
            $dateTime = $row['dateTime'];
            $reason = $row['reason'];
            $detail = $row['detail'];
            $report_status = $row['report_status'];
            
        }
    }else {

    }

    ?>
<!--    Detail-->
    <div class="container">
        <div class="row">
            <div class="col-12 my-2 mt-5">
                <h4 class="text-secondary">View Report Details Send From<span class="badge bg-info text-dark"><?php echo $senderEmail;?></span></h4>
                
            </div>
        </div>
    </div>
    
    <div class="container">

        <div class="row">
            <div class="col-12">
                <a href="page_admin_profile.php" class="btn btn-secondary">Return</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-sm-4">
                Sender's Email:
            </div>
            <div class="col-12 col-sm-8 text-secondary fw-bold">
                <?php echo $senderEmail; ?>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-sm-4">
                Receiver's Email:
            </div>
            <div class="col-12 col-sm-8 text-secondary fw-bold">
                <?php echo $getterEmail; ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-sm-4">
                Report Send Date & Time:
            </div>
            <div class="col-12 col-sm-8 text-secondary fw-bold">
                <?php echo $dateTime; ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-sm-4">
                Reason:
            </div>
            <div class="col-12 col-sm-8 text-secondary fw-bold">
                <?php echo $reason; ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-sm-4">
                Detail:
            </div>
            <div class="col-12 col-sm-8 text-secondary fw-bold">
                <?php echo $detail; ?>
            </div>
        </div>


<!--
        <div class="row mt-3">
            <div class="col-12 col-sm-4">
                Number of warnings Number of Unconfirmed Reports
            </div>
            <div class="col-12 col-sm-8 text-secondary">
                <table class="table table-sm">
                    <tr>
                        <th>Sender's Email</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Number of warnings</th>
                    </tr>
                    
                    <?php

//                    $sql = mysqli_query(getDBconn(),"SELECT reports.getterEmail, reports.reason, reports.report_status FROM reports WHERE reports.getterEmail = '$getterEmail' And reports.report_status != 'pending';");
//                    while($row = mysqli_fetch_assoc($sql)){
//                        $i++;
//                        echo '<tr><td>'
//                        .$row['getterEmail'].'</td><td>'
//                        .$row['reason'].'</td><td>'
//                        .$row['report_status'].'</td><td>'
//                        .$i.'</td></tr>';
//                    }
                    ?>
                    
                </table>
            </div>
        </div>
-->
        <div class="row mt-3">
            <div class="col-12 col-sm-4">
                Number of warnings
            </div>
            <div class="col-12 col-sm-8 text-secondary">
                <table class="table table-sm">
                    <tr>
                        <th>Sender's Email</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Number of warnings</th>
                    </tr>
                    
                    <?php

                    $sql = mysqli_query(getDBconn(),"SELECT reports.getterEmail, reports.reason, reports.report_status FROM reports WHERE reports.getterEmail = '$getterEmail' And reports.report_status != 'pending';");
                    while($row = mysqli_fetch_assoc($sql)){
                        $i++;
                        echo '<tr><td>'
                        .$row['getterEmail'].'</td><td>'
                        .$row['reason'].'</td><td>'
                        .$row['report_status'].'</td><td>'
                        .$i.'</td></tr>';
                    }
                    ?>
                    
                </table>
            </div>
        </div>

		<button id="con_btn"type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendWarn">
            Confirm
        </button>
        <!-- Button trigger modal -->
        

                                    
                               
        <!-- Modal -->
        <form class="p-lg-5 col-12 row g-3" action="confirmReport.php" method="post">
        <div class="modal fade" id="sendWarn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                   
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendWarn">Confirm Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Send Warning To <?php echo $getterEmail; ?>
                    </div>
                    <input id="conValue" type="hidden" value="<?php echo $report_status; ?>" name="warning">
                    <input type="hidden" value="<?php echo $getterEmail; ?>" name="getter">
                    <input type="hidden" value="true" name="confirmRq" id="confirm">
                    
                    <div class="modal-footer">
                      	<a class="btn btn-success" href="confirmReport.php?confirmRq=true&reportID=<?php echo $reportID; ?>">Confirm Request</a>
                      	<a class="btn btn-danger" href="confirmReport.php?confirmRq=false&reportID=<?php echo $reportID; ?>">Cancel Reques</a>
                       
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Return</button>
                    </div>
                   
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
			if($("#conValue").val() == 'Warned' || $("#conValue").val() == 'Reject'){

                $("#con_btn").hide();
                
                
			}
            

			
        });
   
    </script>
	