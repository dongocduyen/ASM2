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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile</title>
</head>
<body>
    <?php
        include 'connect.php';
        if(isset($_POST['updateProfile'])){
            $id = "";
            if(isset($_SESSION['account'])){
                foreach($_SESSION['account'] as $value){
                    $id = $value['ID'];
                }
            }
            
            $username = $_POST['unameUpdate'];
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
                   
                    
                    $sql = "UPDATE users SET username='$username',email='$email', image='$img' WHERE ID = '$id' ";
                    if ($result = $con->query($sql)){
                        move_uploaded_file($_FILES['avatar']['tmp_name'], './images/'.$_FILES['avatar']['name']);
                        $sql = "SELECT * FROM `users` WHERE id = '$id'";
                        $result = $con->query($sql);
                        $data = [];
                        if ($result->num_rows > 0) {

                            //Gắn dữ liệu lấy được vào mảng $data
                            while ($row = $result->fetch_assoc()) {
                                $data[] = $row;
                                
                            }
                            $_SESSION['account'] = $data;
                            
                            
                        }
                    }
                }
            }
            
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
            <h2>Profile</h2>
        </div>
        <div id="wrap">
            <?php
                $html ="";
                if(isset($_SESSION['account'])){
                    foreach($_SESSION['account'] as $value){
                        $html .='
                        <img src=images/'.$value['image'].' alt="Avatar" style="width:100%">
                        <h1>'.$value['username'].'</h1>
                        <p class="title">'.$value['email'].'</p>
                        ';
                    }
                    
                    
                }
            ?>
            <div class="card">
                
                <?php
                    echo $html;
                ?>
                
                <a href="#"><i class="fa fa-dribbble"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-facebook"></i></a>
                <button onclick="document.getElementById('id01').style.display='block'">Update</button>
            </div>
        </div>
        
        
        <!-- Update Modal -->
        <?php
                $updateImg ="";
                if(isset($_SESSION['account'])){
                    foreach($_SESSION['account'] as $value){
                        $updateImg .='
                        <img src=images/'.$value['image'].' alt="Avatar" class="avatar">';
                    }
                    
                    
                }
        ?>
        <div id="id01" class="modal">
  
            <form class="modal-content animate"  method="post" enctype="multipart/form-data">
                <div class="imgcontainer">
                  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                  <?php
                    echo $updateImg;
                  ?>
                </div>
                <?php
                    $updateInfo ="";
                    if(isset($_SESSION['account'])){
                        foreach($_SESSION['account'] as $value){
                            $updateInfo .='
                            
                            <label for="unameSignUp"><b>Username</b></label>
                                <input type="text" placeholder="Enter Username" value ='.$value['username'].' name="unameUpdate" required>
                            <label for="email"><b>Email</b></label>
                                <input type="text" placeholder="Enter Email" value ='.$value['email'].' name="email" required>
                            
                            
                            <label for="pswSignUp"><b>Avatar</b></label>
                                <input type="file"  name="avatar" required>
                            <button name="updateProfile" type="submit">Update</button>';
                        }
                        
                        
                    }
                ?>
                <div class="containerModal">
                    <?php
                        echo $updateInfo;
                    ?>
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
    
</script>
</body>
</html>