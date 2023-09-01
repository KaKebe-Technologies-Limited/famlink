<?php

    // json header to make the return value an allowed json format
    header("Content-Type: application/json");

    include_once('../../../../admin/config.php');

    // establishing the connection to a database
    $obj = new Database();
    $conn = $obj->getConnString();

    $response =[];

    //definition of the task to be processed;
    $useraction = $_GET["apiCall"];

    switch ($useraction){
        // incase the user requests to login
        case "login":
            if($_SERVER['REQUEST_METHOD']==='POST' ){
                $email = $_POST["email"];
                $password = md5($_POST["password"]);

                $query = "SELECT * FROM users WHERE email = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $email);

                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
            
                    // Verify the password
                    if ($password ===$row['password']) {
                        $response["status"] = "success";
                        $response["message"] = "logged successfully";
                        
                    }else{
                        $response["status"] = "failure";
                        $response["message"] = "Invalid email or password.";
                    }
                }else{
                    $response["status"] = "failure";
                    $response["message"] = "Invalid email or password.";
                }

                echo json_encode($response);
                $stmt->close();
                $conn->close();
            }else{
                $response["status"] = "failure";
                $response["message"] = "Method used is not authorized by this api";
                echo json_encode($response);
            }
           
            break;



        
            // incase the user is registering 
        case "register":
            if($_SERVER['REQUEST_METHOD']==='POST' ){
                $full_name = $_POST["full_name"];
                $email = $_POST["email"];
                $phoneNumber = $_POST["phone_number"];
                $address = $_POST["location_address"];
                $profileimage = "https://media.istockphoto.com/vectors/creative-vector-seamless-pattern-vector-id975589890?k=20&m=975589890&s=612x612&w=0&h=2acWhh0ASGWI7vRqofWthsp2UqagVUCQqdmUQLyAs3Y=";                                
                $password = md5($_POST["password"]);
            

                // user type varies 
                //1 - ordinary app user
                // 2 - an admin of the system
                // 3 - superadmin
                $user_type = 1;

                // before registration is done check whether the email address was already taken.
                $is_already_existing = "SELECT * FROM users WHERE email = ?";
                $stmt = $conn->prepare($is_already_existing);

                $stmt->bind_param("s", $email);
                $stmt->execute();

                // check whether there was any return value. If the variable $result
                // is empty then the email address does not exist in our database therefore
                // continue with registration of a user
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $response["status"] = "failure";
                    $response["message"] = "Email was already taken. Consider trying with another email address";
                    // close database connection
                    $stmt->close();
                    $conn->close();
                    return json_encode($response);
                }
                

                // if no email is found continue with the registration of a user;

                $query = "INSERT INTO users(`full_name`,`username`, `email`, `phone_number`, `address`, `profile_image`,`password`) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);

                $stmt->bind_param("sssssss", $full_name,$full_name,$email,$phoneNumber,$address,$profileimage,$password);
                $stmt->execute();
                
                // check if row was affected
                if ($stmt->affected_rows > 0) {
                    $sel = "SELECT * FROM users WHERE email = ?";
                    $payload = $conn->prepare($sel);

                    $payload->bind_param("s", $email);
                    $payload->execute();
                    $result = $stmt->get_result();
                    
                    $row = $result->fetch_assoc();
                    

                    $user = array(                                        
                        'id' => $row->user_id,
                        'fullname' => $row->full_name,
                        'email' => $email,
                        'phone' => $phone_number,
                        'address' => $address,
                        'profileimage' => $profile_image
                    );
                    
                    
                    $response["status"] = "success";
                    $response["message"] = $user;
                } else {
                    $response["status"] = "failure";
                    $response["message"] = "Error inserting record: " . $stmt->error;
                    
                }
                
                echo json_encode($response);
                                

            }else{
                $response["status"] = "failure";
                $response["message"] = "Method used is not authorized by this api";
                echo json_encode($response);
            }

            $stmt->close();
            $conn->close();


            break;

        default:
        $response["status"] = "failure";
            $response["message"] = "Have no permissions to access this api";
            echo json_encode($response);
    }
?>