
        <?php
        
        include("config.php");
        
            $maxsize = 52428800; 
                       
            $name = $_FILES['file1']['name'];
            $target_dir = "videos/";
            $target_file = $target_dir . $_FILES["file1"]["name"];

            // Select file type
            $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

            // Check extension
            if( in_array($videoFileType,$extensions_arr) ){
                
                // Check file size
                if(($_FILES['file1']['size'] >= $maxsize) || ($_FILES["file1"]["size"] == 0)) {
                    echo "File too large. File must be less than 500MB.";
                }else{
                    // Upload
                    if(move_uploaded_file($_FILES['file1']['tmp_name'],$target_file)){
                        // Insert record

                        $video_name=chop($name,'.mp4');
                        $location_mp4=$target_file;

                        $query = "INSERT INTO videos(name,location_mp4) VALUES('".$video_name."','".$location_mp4."')";

                        mysqli_query($con,$query);
                        echo "Upload successfully.";
                    }
                }

            }else{
                echo "Invalid file extension.";
            }
        
        
        ?>

