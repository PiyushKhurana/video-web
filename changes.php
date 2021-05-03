
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

        
        $id=$_REQUEST['id'];
        $watermark_text=$_REQUEST['watermark'];
        $rotate_value=intval($_REQUEST['rotate']);

        $query_str="SELECT * FROM videos Where  id =".$id;
        $fetchVideos = mysqli_query($con, $query_str);
        $row = mysqli_fetch_assoc($fetchVideos);
        $name=$row['name'];
        $path_mp4=$row['location_mp4'];
        $path_jpg=$row['thumbnail'];

        $path_new="videos/".$name."1".".mp4";

        

 
          if($rotate_value==90||$rotate_value==180||$rotate_value==270){

                $video = $ffmpeg->open($path_mp4);
                
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

                unlink($path_mp4);
                rename($path_new,$path_mp4);
                

          }


          if(!empty($watermark_text)){

                $video = $ffmpeg->open($path_mp4);

                $command = "text='$watermark_text': fontfile=OpenSans-Regular.ttf: fontcolor=red: fontsize=80: box=1: boxcolor=black@0.5: boxborderw=5: x=(w-text_w)/2: y=(h-text_h)/2:";
                $video->filters()->custom("drawtext=$command");
                
                $video->save(new FFMpeg\Format\Video\X264(), $path_new);

                unlink($path_mp4);
                rename($path_new,$path_mp4);

         }




        header("Location: /rtcamp/watch.php");
        die();
        

        
        ?>

