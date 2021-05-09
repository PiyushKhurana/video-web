
<?php
include("config.php");




$val = $_GET["id"];

$query_str="SELECT * FROM videos Where  id =".$val;
$fetchVideos = mysqli_query($con, $query_str);
$row = mysqli_fetch_assoc($fetchVideos);
$path_mp4=$row['location_mp4'];
$path_jpg=$row['thumbnail'];

$num = mt_rand(100000,999999); 
$random_path=$path_mp4."?time".$num;



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <title>Edit Videos</title>
    <style>
        #main {
            
        }

        .txt {
            font-family: cursive;
        }
        #role{
            /* border: 3px;
            border-style: solid; */
             margin-top: 20px;
            /*margin-right: 80px;
            margin-left: 80px; */
            text-align: center;
        }
        #player{
            /* border: 3px;
            border-style: solid; */
            margin-top: 6px;
            margin-bottom: 6px;
            text-align: center;
            
        }
        #adv{
            /* border: 3px;
            border-style: solid; */
            text-align: center;
            background-color:#f55c47;
            padding: 10px 10px 10px 10px;
            color:#ffffff;
            

        }
        #some {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        #submit{
            margin-top: 8px;
        }
        #pageloader{
        background: rgba( 255, 255, 255, 0.8 );
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
        }

        #pageloader img{
        left: 50%;
        margin-left: -32px;
        margin-top: -32px;
        position: absolute;
        top: 50%;
        }

    </style>
</head>

<body>

                    

                        <div id="pageloader">
                            <img src="loader.gif" alt="processing..." />
                        </div>


                        <div id="wrapper">
                            <div class="topnav">
                                <a  href="index.html">Home</a>
                                <a href="upload.html">Upload</a>
                                <a href="watch.php">Watch</a>
                                <a href="https://github.com/PiyushKhurana">Author</a>
                            </div>

                            <div id="main">

                                <div style="background-color:#ff971d;padding: 10px 10px 10px 10px;color:#ffffff;">
                                    <h1 class="txt">Video Encoding Challenge - RT Camp</h1>
                                </div>


                                <div id="role" style="background-color:#ff7b54;padding: 10px 10px 10px 10px;color:#ffffff;">
                                    <h2 class="txt" style="color:#ffffff;">Video Editor</h2>
                                </div>


                                <div id="player">
                                    <video width="854" height="480" controls poster='<?php echo $path_jpg;?>'>
                                        <source src='<?php echo $random_path;?>'
                                            type="video/mp4">
                                    </video>
                                </div>

                                <div id="adv" style="color:#ffffff;font-weight:bold;">
                                                
                                    <form id="myform" action='<?php echo "changes.php/?id=".$val;?>' method="post">
                                    <label for="watermark">Watermark:</label>
                                        <input type="text" id="some" placeholder="Watermark Text" name="watermark" value/><br>

                                        <label for="Rotate">Rotate:</label>

                                        <select name="rotate">
                                        <option value="0">Rotate By 0° </option>
                                        <option value="90">Rotate By 90° clockwise</option>
                                        <option value="270">Rotate By  90° counterclockwise</option>
                                        <option value="180">Rotate By 180° </option>
                                        </select>

                                        <input type="submit" id="submit" value="Submit">
                                    </form>


                                </div>

                            </div>
                        </div>


    <script>


        document.getElementById("myform").addEventListener("submit", function () {
            document.getElementById("wrapper").style.display = "none";
            document.getElementById("pageloader").style.display = "block";
        });

 

    </script>

</body>

</html>