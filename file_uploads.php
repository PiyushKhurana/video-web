
        <?php
        
        include("config.php");

        require 'vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();

        $ffmpeg = FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => $_ENV['FFMPEG_BIN_PATH'],
            'ffprobe.binaries' => $_ENV['FFPROBE_BIN_PATH'],
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ), $logger);


        
            $maxsize = 52428800; // 5MB
                       
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                        $video = $ffmpeg->open($target_file);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                    // make thumbnail //
                    
                        $target_dir_thumbs = "thumbs/";
                        $target_file_thumbs = $target_dir_thumbs . $_FILES["file1"]["name"];
                        $str_thumbs=chop($target_file_thumbs,'.mp4');

                        
                         $video
                        ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
                        ->save("{$str_thumbs}.jpg");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                    // make gif //
                        
                        $target_dir_gifs = "gifs/";
                        $target_file_gifs = $target_dir_gifs . $_FILES["file1"]["name"];
                        $str_gifs=chop($target_file_gifs,'.mp4');

                        
                        $video
                        ->gif(FFMpeg\Coordinate\TimeCode::fromSeconds(2), new FFMpeg\Coordinate\Dimension(854, 480), 3)
                        ->save("{$str_gifs}.gif");
                        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                    //  convert to webm  //
                    
                        $target_dir_webm = "webm/";
                        $target_file_webm = $target_dir_webm . $_FILES["file1"]["name"];
                        $str_webm=chop($target_file_webm,'.mp4');

                        $video
                        ->save(new FFMpeg\Format\Video\WebM(), "{$str_webm}.webm");
                        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                        $video_name=chop($name,'.mp4');
                        $location_mp4=$target_file;
                        $location_webm=$str_webm.".webm";
                        $preview=$str_gifs.".gif";
                        $thumbnail=$str_thumbs.".jpg";


                        $query = "INSERT INTO videos(name,location_mp4,location_webm,preview,thumbnail) VALUES('".$video_name."','".$location_mp4."','".$location_webm."','".$preview."','".$thumbnail."')";

                        mysqli_query($con,$query);
                        echo "Upload successfully.";
                    }
                }

            }else{
                echo "Invalid file extension.";
            }
        
        
        ?>

