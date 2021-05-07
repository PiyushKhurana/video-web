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


        $fetchVideos = mysqli_query($con, "SELECT * FROM videos Where isModified = 1 order by updated asc ");
        while($row = mysqli_fetch_assoc($fetchVideos)){
            $id=$row['id'];
            $name=$row['name'];
            $path_mp4=$row['location_mp4'];

            $watermark_text=$row['watermark'];
            $rotate_value=$row['rotate'];


            $extra="C://xampp//htdocs//rtcamp//";

            //$video = $ffmpeg->open($extra.$path_mp4);


            
            $path_new=$extra."videos/".$name."1".".mp4";

        

 
            if($rotate_value==90||$rotate_value==180||$rotate_value==270){
                
                $video = $ffmpeg->open($extra.$path_mp4);
                  //$video = $ffmpeg->open($path_mp4);
                  
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
  
                  unlink($extra.$path_mp4);
                  rename($path_new,$extra.$path_mp4);
                  
  
            }
  
  
            if(!empty($watermark_text)){
  
                  $video = $ffmpeg->open($extra.$path_mp4);
  
                  $command = "text='$watermark_text': fontfile='OpenSans-Regular.ttf': fontcolor=red: fontsize=80: box=1: boxcolor=black@0.5: boxborderw=5: x=(w-text_w)/2: y=(h-text_h)/2:";
                  $video->filters()->custom("drawtext=$command");
                  
                  $video->save(new FFMpeg\Format\Video\X264(), $path_new);
  
                  unlink($extra.$path_mp4);
                  rename($path_new,$extra.$path_mp4);
  
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