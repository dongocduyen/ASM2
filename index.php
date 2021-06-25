<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://css.gg/shopping-cart.css' rel='stylesheet'>
   
    <title>Welcome Duyen Coffe</title>
</head>
<body>
    <?php
        include 'connect.php';
        // Sign Up 
        
        
        if(isset($_POST['signUpSubmit'])){
            $userUp = "";
            $psw = "";
            $userUp = $_POST['unameSignUp'];
            $psw = $_POST['pswSignUp'];
            $email = $_POST['email'];
            if (isset($_FILES['avatar']))
            {
                $img = $_FILES['avatar']['name'];
               
                if ($_FILES['avatar']['error'] > 0)
                {
                    echo 'File Upload Bị Lỗi';
                }
                else{
                    
                    // Upload file
                   
                    
                    $sql = "INSERT INTO users (username , pass,email,image) VALUES ('$userUp' , '$psw' ,'$email','$img')";
                    if ($result = $con->query($sql)){
                        move_uploaded_file($_FILES['avatar']['tmp_name'], './images/'.$_FILES['avatar']['name']);
                        echo "You have successfully registered";
      
                    }
                }
            }
            else{
                echo 'Bạn chưa chọn file upload';
            }

            
        }
        if(isset($_POST['signInSubmit'])){
            $userIn = "";
            $psw = "";
            $userIn = $_POST['unameSignIn'];
            $psw = $_POST['pswSignIn'];

            $sql = "SELECT * FROM `users` WHERE username = '$userIn' AND pass = '$psw'";
            $result = $con->query($sql);
            $data = [];
            if ($result->num_rows > 0) {

                //Gắn dữ liệu lấy được vào mảng $data
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                    
                }
                $_SESSION['account'] = $data;
                
                
            }
            else{
                echo "You have entered the wrong password";
                
            }
            
        }
        $sql = "SELECT * FROM `product` WHERE typeProduct = '1'";

        //Chạy câu SQL
        $result = $con->query($sql);
        //thu var_dump($result)
        //if co data thi num_rows > 0, num_rows =0


        $data = [];
        if ($result->num_rows > 0) {

            //Gắn dữ liệu lấy được vào mảng $data
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $listProduct = '';
        foreach ($data as $value) {
            $listProduct .= '
            <figure>
                <img src="images/'.$value['Images'].'">
                <figcaption>'.$value['name'].'</figcaption>
                <span class="price">$'.$value['price'].'</span>
                <a class="button" href="#">Buy Now</a>
            </figure>';
        }
        $sqli = "SELECT * FROM `product` WHERE typeProduct = '2'";

        //Chạy câu SQL
        $result = $con->query($sqli);
        //thu var_dump($result)
        //if co data thi num_rows > 0, num_rows =0


        $data = [];
        if ($result->num_rows > 0) {

            //Gắn dữ liệu lấy được vào mảng $data
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $food = '';
        foreach ($data as $value) {
            $food .= '
            <figure>
                <img src="images/'.$value['Images'].'">
                <figcaption>'.$value['name'].'</figcaption>
                <span class="price">$'.$value['price'].'</span>
                <a class="button" href="#">Buy Now</a>
            </figure>';
        }

        

        

    ?>  
    
    <div class="container">
        <div class="header">

            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="news.asp">Oder</a></li>
                <li><a href="contact.asp">Contact</a></li>
                <li><a href="about.asp">About</a></li>
                <div class="sign">
                <?php
                    $html = '';
                    if(isset($_SESSION['account'])){
                        $html .= '
                        
                            <li><a href ="profile.php">Profile</a></li>
                            <li><a href ="create-product.php">My Product</a></li>
                            <li><a href ="logout.php">Logout</a></li>
                           
                            
                        ';
                    
                    
                        
                    }
                
                    
                ?>
                    
                    <ul>
                        <?php  
                            echo $html;
                        ?>
                        <li><a href =""><i class="gg-shopping-cart"></i></a></li>
                        <li><a onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Sign In</a></li>
                        <li><a onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Sign Up</a></li>
                    </ul>
                
                </div>
            </ul>
            
        </div>
        <div class="slice_img">
            <div class="img">
                <img src="images/sliceimg1.jpg">

            </div>
            <div class="next_back">
                <ul>
                    
                    <li><a>Back</a></li>
                    <li><a>Next</a></li>
                </ul>
            </div>
    
        </div>
        <div class="title">
            <h2>Type Drink</h2>
        </div>
        <div id="wrap">
            
            <div id="columns" class="columns_4">

            
                <?php
                    echo $listProduct;
                ?>
                
                

              
                
            </div>
        </div>
        <div class="title">
            <h2>Type Food</h2>
        </div>
        <div id="wrap">
            
            <div id="columns" class="columns_4">

            
                <?php
                    echo $food;
                ?>
                
                

              
                
            </div>
        </div>
        <!-- Login Modal -->
        <div id="id01" class="modal">
  
            <form class="modal-content animate"  method="post">
                <div class="imgcontainer">
                  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                  <img src="images/sliceimg2.jpg" alt="Avatar" class="avatar">
                </div>

                <div class="containerModal">
                    <label for="unameSignIn"><b>Username</b></label>
                        <input type="text" placeholder="Enter Username" name="unameSignIn" required>

                    <label for="pswSignIn"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="pswSignIn" required>
                        
                    <button name="signInSubmit" type="submit">Sign In</button>
                    <label>
                        <input type="checkbox" checked="checked" name="rememberSignIn"> Remember me
                    </label>
                    
                </div>

                <div class="containerModal" style="background-color:white">
                  <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                  <span class="psw">Forgot <a href="#">password?</a></span>
                </div>
            </form>
        </div>

        <!-- Register Modal -->
        <div id="id02" class="modal">
  
            <form class="modal-content animate"  method="post" enctype="multipart/form-data">
                <div class="imgcontainer">
                  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                  <img src="images/sliceimg3.jpg" alt="Avatar" class="avatar">
                </div>

                <div class="containerModal">
                    <label for="unameSignUp"><b>Username</b></label>
                        <input type="text" placeholder="Enter Username" name="unameSignUp" required>
                    <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="Enter Email" name="email" required>
                    
                    <label for="pswSignUp"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="pswSignUp" required>
                    
                    <label for="pswSignUp"><b>Avatar</b></label>
                        <input type="file"  name="avatar" required>
                    <button name="signUpSubmit" type="submit">Sign Up</button>
                    <label>
                        <input type="checkbox" checked="checked" name="rememberSignUp"> Remember me
                    </label>
                </div>

                <div class="containerModal" style="background-color:white">
                  <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
                  <span class="psw">Forgot <a href="#">password?</a></span>
                </div>
            </form>
        </div>

       
        
        <div class="footer">
            <h2>Enjoy your meal at Duyen Coffee</h2>
        </div>

    </div>
<script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    // Get the modal
    var modal = document.getElementById('id02');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    // Get the modal
    var modal = document.getElementById('id03');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>