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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Profile</title>
</head>
<body>
    <?php
        include 'connect.php';
        if(isset($_POST['createProduct'])){
            
            
            $nameProduct = $_POST['nameDrink'];
            $price = $_POST['price'];
            
            if (isset($_FILES['avatar']))
            {
                $img = $_FILES['avatar']['name'];
               
                if ($_FILES['avatar']['error'] > 0)
                {
                    echo 'File Upload Bị Lỗi';
                }
                else{
                    
                   
                    
                    $sql = "INSERT INTO product (name , price,images,typeProduct) VALUES ('$nameProduct' , '$price' ,'$img','1')";
                    if ($result = $con->query($sql)){
                        move_uploaded_file($_FILES['avatar']['tmp_name'], './images/'.$_FILES['avatar']['name']);
                        echo "You have successfully product";
      
                    }
                }
                
            }
            
            

            
        }
        if(isset($_POST['createFood'])){
            
            
            $nameProduct = $_POST['nameFood'];
            $price = $_POST['price'];
            
            if (isset($_FILES['avatar']))
            {
                $img = $_FILES['avatar']['name'];
               
                if ($_FILES['avatar']['error'] > 0)
                {
                    echo 'File Upload Bị Lỗi';
                }
                else{
                    
                   
                    
                    $sql = "INSERT INTO product (name , price,images,typeProduct) VALUES ('$nameProduct' , '$price' ,'$img','2')";
                    if ($result = $con->query($sql)){
                        move_uploaded_file($_FILES['avatar']['tmp_name'], './images/'.$_FILES['avatar']['name']);
                        echo "You have successfully food";
      
                    }
                }
                
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

        $drink = '';
        foreach ($data as $value) {
            $drink .= '
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>

                <th>Action</th>
            </tr>
            <tr>
                <td>'.$value['name'].'</td>
                <td class="imgTable"><img src="images/'.$value['Images'].'"></td>
                <td>$'.$value['price'].'</td>
                <td><a href="deleteMyProduct.php?id='.$value['id'].'"><i style="color:red" class="material-icons">delete_forever</i></a></td>
                
            </tr>';
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
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>

                <th>Action</th>
            </tr>
            <tr>
                <td>'.$value['name'].'</td>
                <td class="imgTable"><img src="images/'.$value['Images'].'"></td>
                <td>$'.$value['price'].'</td>
                <td><a href="deleteMyProduct.php?id='.$value['id'].'"><i style="color:red" class="material-icons">delete_forever</i></a></td>
                
            </tr>';
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
        <div class="aCreateProduct">
            <h2><a onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Create Drink</a></h2>
            
        </div>
        <div id="wrap">
            <table class ="tableProduct">
                
                <?php
                    echo $drink;
                ?>
                

                
            </table>
        </div>
        <div id="id01" class="modal">
  
            <form class="modal-content animate"  method="post" enctype="multipart/form-data">
                <div class="imgcontainer">
                  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                  <img src="images/sliceimg2.jpg" alt="Avatar" class="avatar">
                </div>

                <div class="containerModal">
                    <label for="name"><b>Name Drink</b></label>
                        <input type="text" placeholder="Enter Name Drink" name="nameDrink" required>

                    
                    <label for="price"><b>Price Drink</b></label>
                        <input type="text" placeholder="Enter Price Drink" name="price" required>    
                    <label for="avatar"><b>Images</b></label>
                        <input type="file"  name="avatar" required>
                    <button name="createProduct" type="submit">Create</button>
                    <label>
                        
                        <input type="checkbox" checked="checked" name="rememberSignIn"> Accpect Create Drink
                    </label>
                    
                </div>

                <div class="containerModal" style="background-color:white">
                  <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                  
                </div>
            </form>
        </div>
        <div class="aCreateProduct">
            <h2><a onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Create Food</a></h2>
            
        </div>
        <div id="wrap">
            <table class ="tableProduct">
                
                <?php
                    echo $food;
                ?>
                

                
            </table>
        </div>
        <div id="id02" class="modal">
  
            <form class="modal-content animate"  method="post" enctype="multipart/form-data">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="images/sliceimg2.jpg" alt="Avatar" class="avatar">
                </div>

                <div class="containerModal">
                    <label for="name"><b>Name Food</b></label>
                        <input type="text" placeholder="Enter Name Food" name="nameFood" required>

                    
                    <label for="price"><b>Price Food</b></label>
                        <input type="text" placeholder="Enter Price Food" name="price" required>    
                    <label for="avatar"><b>Images</b></label>
                        <input type="file"  name="avatar" required>
                    <button name="createFood" type="submit">Create</button>
                    <label>
                        
                        <input type="checkbox" checked="checked" name="rememberSignIn"> Accpect Create Drink
                    </label>
                    
                </div>

                <div class="containerModal" style="background-color:white">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                    
                </div>
            </form>
        </div>
        <!-- Update Modal -->
        


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