<?php 
    // Establish connection with the database
    //$con = mysqli_connect("lib-jss.ct4teqpkgci2.us-east-1.rds.amazonaws.com","admin","mysql123","attendance_management_system");
    //$con = mysqli_connect('127.0.0.1','root','mysql123','attendance_management_system');
    $con = mysqli_connect("localhost","root","mysql123","attendance_management_system");
    // If connection failed - give error
    if(!$con) {
        die ("Could not connect to database" . mysqli_connect_error());
    }

    // If desired database is not selected 
    if(!mysqli_select_db($con, 'attendance_management_system'))
    {
        echo 'Database not selected';
    }

    // POST from FORM
    $lib_id = $_POST['lib_id'];
    $password = $_POST['password'];

    if ($lib_id != "") {
        //$result = mysqli_query($con,"SELECT * FROM `Library_card_index` WHERE `lib_id`=$lib_id");   
	//$rows = mysqli_num_rows($result);
	$result = mysqli_query($con,"SELECT * FROM `Library_card_index` LEFT JOIN `Library_ledger` ON `Library_card_index`.`lib_id`=`Library_ledger`.`lib_id` WHERE `Library_ledger`.`lib_id` IS NULL AND `Library_card_index`.`lib_id`=$lib_id");
	$rows1 = mysqli_num_rows($result);
	$result = mysqli_query($con,"SELECT * FROM `Library_card_index` INNER JOIN `Library_ledger` ON `Library_card_index`.`lib_id`=`Library_ledger`.`lib_id` WHERE `Library_ledger`.`status`=1");
        $rows2 = mysqli_num_rows($result);	
        
        if($rows1 == 1 || $rows2 == 0) {

            $pass_verify = mysqli_query($con,"SELECT * FROM `Library_card_index` WHERE `lib_id`=$lib_id AND `password`='$password'"); 
            $pass_verify_rows = mysqli_num_rows($pass_verify);
            $result = mysqli_query($con,"SELECT * FROM `Library_card_index` WHERE `lib_id`=$lib_id");
            $row=mysqli_fetch_assoc($result);
            $result2 = mysqli_query($con,"SELECT * FROM `Students` WHERE `lib_id`=$lib_id");
	    $row2 = mysqli_fetch_assoc($result2);
	    $currentTimestamp = time();
	    $newTimestamp = $currentTimestamp + (5 * 60 * 60) + (30 * 60);
	    $formattedMySQLTimestamp = date("Y-m-d H:i:s", $newTimestamp);
            //$hash=$row['password'];
            //$verify=password_verify($password,$hash);
            if($pass_verify_rows==1) {
            $insert_entry = "INSERT INTO `Library_ledger` (lib_id,name,branch,entry) VALUES ($lib_id,'{$row2['name']}','{$row2['branch']}','$formattedMySQLTimestamp')";
            mysqli_query($con, $insert_entry);
            ?>
            <!-- SUCCESS ON ENTRY  -->
            <html>
                <head>
                    <link rel="stylesheet" type="text/css" href="style.css">
                    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                </head>
                <body>
                    <p style="text-align:center"> .. </p>
            
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Successful',
                        showConfirmButton: false,
                        timer: 2300
                    }).then(() => {
                            window.location.href = "index.html";
                    })
                </script>
                </body>
            </html>

            <?php
	    }

	    /*else if ($row2>0){
                ?>
                    <!-- ALREADY ENTERED -->
                    <html>
                        <head>
                            <link rel="stylesheet" type="text/css" href="style.css">
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                        </head>
                        <body>
                        <p style="text-align:center"> .. </p>
                            <script>
                            Swal.fire({
                                title: 'Attention!',
                                text: 'You are already present in library or did not exit last time',
                                icon: 'error',
                                confirmButtonText: 'Retry'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                        window.location.href = "index.html";
                                    //   Swal.fire(
                                    //     'Deleted!',
                                    //     'Your file has been deleted.',
                                    //     'success'
                                    //   )
                                    }
                                })
                        </script>
                        </body>
                    </html>
                <?php
            }

            else {
                ?>
                    <!-- WRONG PASSWORD -->
                    <html>
                        <head>
                            <link rel="stylesheet" type="text/css" href="style.css">
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                        </head>
                        <body>
                        <p style="text-align:center"> .. </p>
                            <script>
                            Swal.fire({
                                title: 'Invalid Credentials!',
                                text: 'Please check your user ID and password',
                                icon: 'error',
                                confirmButtonText: 'Retry'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                        window.location.href = "index.html";
                                    //   Swal.fire(
                                    //     'Deleted!',
                                    //     'Your file has been deleted.',
                                    //     'success'
                                    //   )
                                    }
                                })
                        </script>
                        </body>
                    </html>
                <?php
	    }*/
	}
        else if ($rows1==0){
            ?>
            <!-- User does not exist -->
            <html>
                <head>
                    <link rel="stylesheet" type="text/css" href="style.css">
                    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                </head>
                <body>
                <p style="text-align:center"> .. </p>
                <script>
                Swal.fire({
                    title: 'User with this user ID does not exist',
                    text: "Do you want to register?",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#37bf7b',
                    confirmButtonText: 'Yes, register!',
                    timer:5000
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "first_choice_page.html";
                    } else {
                        window.location.href = "index.html";
                    }
                })
                </script>
                </body>
            </html>
            <?php
	}
	else if ($rows2>0){
                ?>
                    <!-- ALREADY ENTERED -->
                    <html>
                        <head>
                            <link rel="stylesheet" type="text/css" href="style.css">
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                        </head>
                        <body>
                        <p style="text-align:center"> .. </p>
                            <script>
                            Swal.fire({
                                title: 'Attention!',
                                text: 'You are already inside the library or did not exit last time',
                                icon: 'error',
                                confirmButtonText: 'Retry'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                        window.location.href = "index.html";
                                    //   Swal.fire(
                                    //     'Deleted!',
                                    //     'Your file has been deleted.',
                                    //     'success'
                                    //   )
                                    }
                                })
                        </script>
                        </body>
                    </html>
                <?php
	}
	    else {
                ?>
                    <!-- WRONG PASSWORD -->
                    <html>
                        <head>
                            <link rel="stylesheet" type="text/css" href="style.css">
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                        </head>
                        <body>
                        <p style="text-align:center"> .. </p>
                            <script>
                            Swal.fire({
                                title: 'Invalid Credentials!',
                                text: 'Please check your user ID and password',
                                icon: 'error',
                                confirmButtonText: 'Retry'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                        window.location.href = "index.html";
                                    //   Swal.fire(
                                    //     'Deleted!',
                                    //     'Your file has been deleted.',
                                    //     'success'
                                    //   )
                                    }
                                })
                        </script>
                        </body>
                    </html>
                <?php
            }
    }
    
    $exit_id = $_POST['exit_id'];
    $suggestion = $_POST['suggestion'];
    $currentTimestamp = time();
    $newTimestamp = $currentTimestamp + (5 * 60 * 60) + (30 * 60);
    $formattedMySQLTimestamp = date("Y-m-d H:i:s", $newTimestamp);
    mysqli_query($con,"UPDATE Library_ledger SET SUGGESTION='$suggestion', `exit`='$formattedMySQLTimestamp' WHERE lib_id=$exit_id");
    // echo $exit_id;
    if($exit_id != "") {
        $verify = mysqli_query($con,"SELECT lib_id, status FROM `Library_ledger` WHERE `lib_id`=$exit_id AND `status` = 1;
        ");
        $res = mysqli_num_rows($verify);
        // echo $res;
        if($res == 0) {
            ?>
            <!-- Error message if lib_id on exit is invalid or never entered before -->
            <html>
                <head>
                    <link rel="stylesheet" type="text/css" href="style.css">
                    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                </head>
                <body>
                <p style="text-align:center"> .. </p>
                    <script>
                    Swal.fire({
                        title: 'Exit Failed!',
                        text: 'Please check if you have already entered the library. Make sure you are registered',
                        icon: 'error',
                        confirmButtonText: 'Retry'
                    }).then((result) => {
                        if (result.isConfirmed) {
                                window.location.href = "index.html";
                            
                            }
                        })
                </script>
                </body>
            </html>
            <?php
        }
        if($res > 0) {
            $sql = "CALL exit_library($exit_id);";
            $query = mysqli_query($con, $sql);
            if(!$query) {
                echo "Failed exit";
            }
            else {
                ?>
                <!-- SUCCESS EXIT -->
                <html>
                <head>
                    <link rel="stylesheet" type="text/css" href="style.css">
                    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                </head>
                <body>
                    <p style="text-align:center"> .. </p>
            
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Exit Successful',
                        showConfirmButton: false,
                        timer: 2300
                    }).then(() => {
                            window.location.href = "index.html";
                    })
                </script>
                </body>
            </html>
            <?php
            }
        }
    } 


?>

