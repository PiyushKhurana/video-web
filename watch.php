<?php
    include("config.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="30">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Watch</title>
    <style>
        #row {
            display: inline-block;
            margin: 10px;
        }

        #main {
            
        }

        .txt {
            font-family: cursive;
        }
        h3{
            font-family: cursive;
            color:#ff7b54;
        }
        .edit{
            display: block;
    width: 80px;
    height: 25px;
    background:#ff971d;
    padding: 5px;
    text-align: center;
    border-radius: 5px;
    color: white;
    line-height: 25px;
    text-decoration: none;
    box-shadow: 1px 1px 1px 1px;
        }
     #spec{
         margin-top:20px;
        background-color:#ff7b54;
        padding: 10px 10px 10px 10px;
     }
     h2{
         color:white;
         font-weight: 10;
     }
    </style>
</head>

<body>
<div class="topnav">
        <a  href="index.html">Home</a>
        <a href="upload.html">Upload</a>
        <a class="active" href="watch.php">Watch</a>
        <a href="https://github.com/PiyushKhurana">Author</a>
      </div>
    <div id="main">
        <div style="background-color:#ff971d;padding: 10px 10px 10px 10px;color:#ffffff;">
            <h1 class="txt">Video Encoding Challenge - RT Camp</h1>
        </div>


  
        <?php
        $fetchVideos = mysqli_query($con, "SELECT * FROM videos ORDER BY id DESC");
        while($row = mysqli_fetch_assoc($fetchVideos)){
            $id=$row['id'];
            $isProcessed=$row['isProcessed'];
            $isModified=$row['isModified'];

        
           if($isProcessed==0&&$isModified==0){

            $name=$row['name'];
                $video_location=$row['location'];
                $video_format=strtoupper(substr($video_location, strrpos($video_location, '.') + 1));
                $num = mt_rand(100000,999999); 
                $random_path=$video_location."?time".$num;
                
    
                echo "<div>";
                echo "<div id='spec'>";
    
                    echo "<h2 class='txt'>Video Title : $name</h2>";
                    echo "<a class='edit' href='edit.php?id=".$id."'>Edit Video</a>";
    
                echo "</div>";
                echo "<div >";
                echo "<div id='row'>";
                echo "<h3>$video_format Format</h3>";
                echo "<video width='320' height='240' autoplay muted controls ><source src='".$random_path."' type='video/mp4'></video>";
                echo "</div>";
                echo "<div id='row'>";
                echo "<h3>WEBM Format</h3>";
                echo "<video width='320' height='240'  poster='spinner.gif' style=' object-fit:none;'><source src='' type='video/mp4'></video>";
                echo "</div>";
                echo "<div id='row'>";
                echo "<h3>GIF Format</h3>";
                echo "<video width='320' height='240' poster='spinner.gif' style=' object-fit:none;' ><source src='' type='video/mp4'></video>";
                echo "</div>";
                    
                echo "</div>";
           echo "</div>";

           }elseif($isProcessed==0&&$isModified==1){


            $name=$row['name'];
            $video_location=$row['location'];
                $video_format=strtoupper(substr($video_location, strrpos($video_location, '.') + 1));
    
                echo "<div>";
                echo "<div id='spec'>";
    
                    echo "<h2 class='txt'>Video Title : $name</h2>";
                    echo "<a class='edit' href='edit.php?id=".$id."'>Edit Video</a>";
    
                echo "</div>";
                echo "<div >";
                echo "<div id='row'>";
                echo "<h3>$video_format Format</h3>";
                echo "<video width='320' height='240'  poster='spinner.gif' style=' object-fit:none;'><source src='' type='video/mp4'></video>";
                echo "</div>";
                echo "<div id='row'>";
                echo "<h3>WEBM Format</h3>";
                echo "<video width='320' height='240'  poster='spinner.gif' style=' object-fit:none;'><source src='' type='video/mp4'></video>";
                echo "</div>";
                echo "<div id='row'>";
                echo "<h3>GIF Format</h3>";
                echo "<video width='320' height='240' poster='spinner.gif' style=' object-fit:none;' ><source src='' type='video/mp4'></video>";
                echo "</div>";
                    
                echo "</div>";
           echo "</div>";


           }elseif($isProcessed==1&&$isModified==0){

            $name=$row['name'];
                $video_location=$row['location'];
                $video_format=strtoupper(substr($video_location, strrpos($video_location, '.') + 1));
                $path_webm=$row['location_webm'];
                $path_gif=$row['preview'];
                $path_jpg=$row['thumbnail'];
                $num = mt_rand(100000,999999); 
                $random_path=$video_location."?time".$num;
    
    
                echo "<div>";
                echo "<div id='spec'>";
    
                    echo "<h2 class='txt'>Video Title : $name</h2>";
                    echo "<a class='edit' href='edit.php?id=".$id."'>Edit Video</a>";
    
                echo "</div>";
                echo "<div >";
                echo "<div id='row'>";
                echo "<h3>$video_format Format</h3>";
                echo "<video width='320' height='240' autoplay muted controls ><source src='".$random_path."' type='video/mp4'></video>";
                echo "</div>";
                echo "<div id='row'>";
                echo "<h3>WEBM Format</h3>";
                echo "<video width='320' height='240' autoplay muted controls ><source src='".$path_webm."' type='video/mp4'></video>";
                echo "</div>";
                echo "<div id='row'>";
                echo "<h3>GIF Format</h3>";
                echo "<video width='320' height='240' poster='".$path_gif."' ><source src='' type='video/mp4'></video>";
                echo "</div>";
                    
                echo "</div>";
           echo "</div>";

           }else {
               
            $name=$row['name'];
            $video_location=$row['location'];
                $video_format=strtoupper(substr($video_location, strrpos($video_location, '.') + 1));
                $path_webm=$row['location_webm'];
                $path_gif=$row['preview'];
    
    
                echo "<div>";
                echo "<div id='spec'>";
    
                    echo "<h2 class='txt'>Video Title : $name</h2>";
                    echo "<a class='edit' href='edit.php?id=".$id."'>Edit Video</a>";
    
                echo "</div>";
                echo "<div >";
                echo "<div id='row'>";
                echo "<h3>$video_format Format</h3>";
                echo "<video width='320' height='240'  poster='spinner.gif' style=' object-fit:none;'><source src='' type='video/mp4'></video>";
                echo "</div>";
                echo "<div id='row'>";
                echo "<h3>WEBM Format</h3>";
                echo "<video width='320' height='240' autoplay muted controls ><source src='".$path_webm."' type='video/mp4'></video>";
                echo "</div>";
                echo "<div id='row'>";
                echo "<h3>GIF Format</h3>";
                echo "<video width='320' height='240' poster='".$path_gif."' ><source src='' type='video/mp4'></video>";
                echo "</div>";
                    
                echo "</div>";
           echo "</div>";


           }

        }
        ?>

    </div>
</body>

</html>