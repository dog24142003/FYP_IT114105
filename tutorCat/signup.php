<?php
    if(isset($_POST['submit'])){
        $firstName = $_POST['firstname'];
        $lastName = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmpassword'];
        $allSubject = "";
        $account = $_POST['account'];
        
        if(isset($_POST['subject'])){
            $i = 0;
            $len = count($_POST['subject']);
            foreach($_POST['subject'] as $subject) {
                if ($i == $len - 1) {
                    $allSubject .= $subject;
                }else {
                    $allSubject .= $subject . ",";
                }
                $i++;
            }
        }else{
            $allSubject = NULL;
        }
        
        //echo $firstName . " " . $lastName . " " . $email . " " . $password . " " . $allSubject;

        require_once('conn.php');
        $ran_id = rand(time(), 100000000);
        
        if($account == 'Student') {
            $sql = mysqli_query(getDBconn(), "SELECT email FROM student WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0) {
                echo '<script>alert("This email already exist!");
                window.location.href="index.php?signup";</script>';
            }else{
                $sql = "INSERT INTO student (UniqueID, firstname, lastname, email, password, subject)
                VALUES ('$ran_id', '$firstName', '$lastName', '$email', '$password', '$allSubject')";
                if(mysqli_query(getDBconn(), $sql)){
                    echo '<script>alert("Congratulations, your account has been successfully created.");
                    window.location.href="index.php?login";</script>';
        
                }else{  
                    echo "Could not insert record: ". mysqli_error($conn);     
                }
            }

            
        }else {
            $sql = mysqli_query(getDBconn(), "SELECT email FROM tutor WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0) {
                echo '<script>alert("This email already exist!");
                window.location.href="index.php?signup";</script>';
            }else{
                $sql = "INSERT INTO tutor (UniqueID, firstname, lastname, email, password, subject)
                VALUES ('$ran_id', '$firstName', '$lastName', '$email', '$password', '$allSubject')";

                if(mysqli_query(getDBconn(), $sql)){
                    echo '<script>alert("Congratulations, your account has been successfully created.");
                    window.location.href="index.php?login";</script>';

                }else{  
                    echo "Could not insert record: ". mysqli_error($conn);     
                }
            }
        }
           
        mysqli_close(getDBconn()); 
    }
?>