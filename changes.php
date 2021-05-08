
        <?php

        include("config.php");

        
        $id=$_REQUEST['id'];
        $watermark_text=$_REQUEST['watermark'];
        $rotate_value=intval($_REQUEST['rotate']);

        if (strlen(trim($watermark_text)) == 0){

                if($rotate_value==90||$rotate_value==180||$rotate_value==270){

                        $query = "UPDATE videos set isModified=1 , rotate='$rotate_value'  where id='$id'";
                        mysqli_query($con,$query);
                        
                }
        }
        else {
                $query = "UPDATE videos set isModified=1 , watermark='$watermark_text' , rotate='$rotate_value'  where id='$id'";
                mysqli_query($con,$query);
        }
        
        

        header("Location: /rtcamp/watch.php");
        die();
        

        
        ?>

