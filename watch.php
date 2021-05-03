<?php
    include("config.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Watch</title>
    <style>
        #row {
            display: inline-block;
            margin: 10px;
        }

        #main {
            margin: 40px;
        }

        .txt {
            font-family: Sans-serif;
        }
        .edit{
            display: block;
    width: 80px;
    height: 25px;
    background:#4257f5;
    padding: 5px;
    text-align: center;
    border-radius: 5px;
    color: white;
    line-height: 25px;
    text-decoration: none;
        }
     
    </style>
</head>

<body>
<div class="topnav">
        <a  href="index.html">Home</a>
        <a href="upload.html">Upload</a>
        <a class="active" href="#watch">Watch</a>
        <a href="#about">About</a>
      </div>
    <div id="main">
        <div>
            <h1 class="txt">Video Encoding Challenge - RT Camp</h1>
        </div>


  
        <?php
        $fetchVideos = mysqli_query($con, "SELECT * FROM videos ORDER BY id DESC");
        while($row = mysqli_fetch_assoc($fetchVideos)){
            $id=$row['id'];
            $name=$row['name'];
            $path_mp4=$row['location_mp4'];
            $path_webm=$row['location_webm'];
            $path_gif=$row['preview'];
            $path_jpg=$row['thumbnail'];
            $num = mt_rand(100000,999999); 
            $random_path=$path_mp4."?time".$num;

            // echo "<div >";
            // echo "<video src='".$location."' controls width='320px' height='200px' >";
            // echo "</div>";

            echo "<div>";
            echo "<div id='headd'>";

                echo "<h3 class='txt'>$name</h3>";
                echo "<a class='edit' href='edit.php?id=".$id."'>Edit Video</a>";

            echo "</div>";
            echo "<div >";
            echo "<div id='row'>";
            echo "<video width='320' height='240' autoplay muted><source src='".$random_path."' type='video/mp4'></video>";
            echo "</div>";
            echo "<div id='row'>";
            echo "<video width='320' height='240' autoplay muted><source src='".$path_webm."' type='video/mp4'></video>";
            echo "</div>";
                
            echo "</div>";
       echo "</div>";


        }
        ?>




        <!-- <div>
            <div>

                <h3 class="txt">Sample Video 1</h3>
                <a href="#">Edit Video</a>

            </div>
            <div id="">
                <div id="row">
                    <video width="320" height="240" autoplay muted>
                        <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4"
                            type="video/mp4">
                    </video>
                </div>
                <div id="row">
                    <video width="320" height="240" autoplay muted>
                        <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4"
                            type="video/mp4">
                    </video>
                </div>
                <div id="row">
                    <video width="320" height="240" autoplay muted>
                        <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4"
                            type="video/mp4">
                    </video>
                </div>
            </div>
        </div>




        <div>
            <div>

                <h3 class="txt">Sample Video 2</h3>
                <a href="#">Edit Video</a>
            </div>
            <div>
                <div id="row">
                    <video width="320" height="240" autoplay muted>
                        <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4"
                            type="video/mp4">
                    </video>
                </div>
                <div id="row">
                    <video width="320" height="240" autoplay muted>
                        <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4"
                            type="video/mp4">
                    </video>
                </div>
                <div id="row">
                    <video width="320" height="240" autoplay muted>
                        <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4"
                            type="video/mp4">
                    </video>
                </div>
            </div>
        </div> -->


    </div>
</body>

</html>