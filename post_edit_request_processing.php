<?php

include("config.php");

require 'vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();

        $ffmpeg = FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => $_ENV['FFMPEG_BIN_PATH'],
            'ffprobe.binaries' => $_ENV['FFPROBE_BIN_PATH'],
            'timeout'          => 0, // The timeout for the underlying process
            'ffmpeg.threads'   => 1,   // The number of threads that FFMpeg should use
        ));


        $fetchVideos = mysqli_query($con, "SELECT * FROM videos Where isModified = 1 order by updated asc ");
        while($row = mysqli_fetch_assoc($fetchVideos)){
            $id=$row['id'];
            $name=$row['name'];
            $video_location=$row['location'];
            $video_format=substr($video_location, strrpos($video_location, '.') + 1);
            $watermark_text=$row['watermark'];
            $rotate_value=$row['rotate'];


            $extra=__DIR__.'/';

            //$video = $ffmpeg->open($extra.$video_location);

            
            
            $path_new=$extra."videos/".$name."1.".$video_format;

        

 
            if($rotate_value==90||$rotate_value==180||$rotate_value==270){
                
                $video = $ffmpeg->open($extra.$video_location);
                  //$video = $ffmpeg->open($video_location);
                  
                  if($rotate_value==90){
                          $angle=FFMpeg\Filters\Video\RotateFilter::ROTATE_90;
                  }
                  elseif($rotate_value==180){
                          $angle=FFMpeg\Filters\Video\RotateFilter::ROTATE_180;
                  }
                  else {
                          $angle=FFMpeg\Filters\Video\RotateFilter::ROTATE_270;
                  }
  
  
                  $video->filters()->rotate($angle);
                  $video->save(new FFMpeg\Format\Video\X264(), $path_new);
  
                  unlink($extra.$video_location);
                  rename($path_new,$extra.$video_location);
                  
  
            }
  
  
            if(!empty($watermark_text)){
  
                  $video = $ffmpeg->open($extra.$video_location);
  
                  $command = "text='$watermark_text': fontfile='/var/www/html/Open_Sans/OpenSans-Regular.ttf': fontcolor=red: fontsize=80: box=1: boxcolor=black@0.5: boxborderw=5: x=(w-text_w)/2: y=(h-text_h)/2:";
                  $video->filters()->custom("drawtext=$command");
                  
                  $video->save(new FFMpeg\Format\Video\X264(), $path_new);
  
                  unlink($extra.$video_location);
                  rename($path_new,$extra.$video_location);
  
           }
  
  
  
  
        //   header("Location: /rtcamp/watch.php");
        //   die();
          


                

                $query = "UPDATE videos set isModified=0 , watermark='' , rotate=0  where id='$id'";
                mysqli_query($con,$query);

                $datestamp=date('Y-m-d H:i:s');
               	echo "Successfully Proceessed Video  at  ".$datestamp;
               
                

           
        }

        $datestamp=date('Y-m-d H:i:s');
        echo "Successfuly executed cron job at ".$datestamp;

?>
