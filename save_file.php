<?php
    if(ISSET($_POST['save'])){
        $filename = $_FILES['file']['name'];
        $filesize = $_FILES['file']['size'];
        $filetemp = $_FILES['file']['tmp_name'];
 
        if($filesize > 500000){
            echo "<script>alert('File too large to upload')</script>";
            echo "<script>window.location = 'index.php'</script>";
        }else{
            $file = explode(".", $filename);
            $file_ext = end($file);
            $ext = array("png", "jpg", "jpeg");
 
            if(in_array($file_ext, $ext)){
                $location = "folder1/".$filename;
                if(move_uploaded_file($filetemp, $location)){
                    echo "<script>alert('File Saved!')</script>";
                    echo "<script>window.location = 'index.php'</script>";
                }
            }else{
                echo "<script>alert('Only images allowed')</script>";
                echo "<script>window.location = 'index.php'</script>";
            }
        }
    }
?>