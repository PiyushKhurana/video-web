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
        ));


        $fetchVideos = mysqli_query($con, "SELECT * FROM videos Where isProcessed = 0 order by created asc ");
        while($row = mysqli_fetch_assoc($fetchVideos)){
            $id=$row['id'];
            $name=$row['name'];
            $path_mp4=$row['location_mp4'];


            $extra="C://xampp//htdocs//rtcamp//";
            $video = $ffmpeg->open($extra.$path_mp4);


            
            //Thumbnail generation

                $target_dir_thumbs = $extra."thumbs/";
                $target_file_thumbs = $target_dir_thumbs.$name;

                $video
                ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(3))
                ->save("{$target_file_thumbs}.jpg");


            //Gif generation

                $target_dir_gifs = $extra."gifs/";
                $target_file_gifs = $target_dir_gifs.$name;
                
                $video
                ->gif(FFMpeg\Coordinate\TimeCode::fromSeconds(2), new FFMpeg\Coordinate\Dimension(854, 480), 3)
                ->save("{$target_file_gifs}.gif");


            // Convert mp4 to webm

                $target_dir_webm = $extra."webm/";
                $target_file_webm = $target_dir_webm.$name;

                $video
                ->save(new FFMpeg\Format\Video\WebM(), "{$target_file_webm}.webm");


                $thumbnail      = "thumbs/" .$name. ".jpg";
                $preview        = "gifs/"   .$name. ".gif";
                $location_webm  = "webm/"   .$name. ".webm";

                

                $query = "UPDATE videos set thumbnail='$thumbnail', preview='$preview', location_webm='$location_webm' , isProcessed=1 where id='$id'";
                mysqli_query($con,$query);

                $datestamp=date('Y-m-d H:i:s');
		        echo "Successfuly Processed Uploaded video  at ".$datestamp;
               
                

           
        }
    
    echo "Successfully executed cron job at ".date('Y-m-d H:i:s');

?>