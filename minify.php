<?php

if ((isset($_FILES['file']['type']) && $_FILES['file']['type'] != NULL)
            || (isset($_POST['unmin']) && $_POST['unmin'] != NULL)
            || (isset($argv[1]))){
    
            require_once('minify.class.php');
            $MINIFY = new MINIFY;
    
            if(isset($argv[1])){
                $shortopts = "f::";
                $longopts = array("file::","dest::");
                $arguments = getopt($shortopts, $longopts);
    
                if(isset($arguments['dest'])){
                    $filepath = $arguments['dest'];
                }
                else{
                    $filepath = "new.min";
                }
    
                $MINIFY->commandMinify($arguments['file'], $filepath);
            }
            elseif($_FILES['file']['type'] != NULL){
                $files = $_FILES;
                $ogFile=  pathinfo($files['file']['name']);
                $part1 = $ogFile['filename'];
                $part2 = '.min.';
                $part3 = $ogFile['extension'];
                $newMin = $part1.$part2.$part3;
            
                if ($files['file']['error'] == UPLOAD_ERR_OK               //checks for errors
                && is_uploaded_file($files['file']['tmp_name'])) { //checks that file is uploaded
                    $MINIFY->fromFile($files['file']['tmp_name']);
                    $MINIFY->browserDL($newMin);
               }else{echo"error uploading file, please try again";}
            }
            elseif($_POST['unmin'] != NULL){
                $code = $_POST['unmin'];
                $type = $_POST['fileType'];
                $name = $_POST['fileName'];
                if(isset($_POST['other']) && ($_POST['other'] != '')){
                    $type=$_POST['other'];      
                }
                $newFile = $name.".min.".$type;

                $MINIFY->readFile($code);
                $MINIFY->browserDL($newFile);
            }    
        
}else{
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Minifier</title>
        <style type="text/css">
            form#minifier{
                position: absolute;
width: 800px;
left: 50%;
margin-left: -400px;
            }
            
            #minifier >textarea{
                width: 100%;
margin: 2px 0px;
height: 430px;
resize: vertical;
            }
            
            #minifier >select, #minifier >input{
                background: #333;
color: #fff;
width: 200px;
height: 30px;
            }
            
            input{
                border: none !important;
                
            }
            
            #minify{
                width: 200px;
                height: 30px;
                background: #333;
                color: #fff;
                border: none;
                border-radius: 5px;
            }
            
        </style>
    </head>
    <body>
        <form id="minifier" action="" method="post" enctype="multipart/form-data">
            <textarea id="unmin" name="unmin" rows="30" cols="100"></textarea>
            <select form="minifier" name="fileType">
                <option>--Filetype--</option>
                <option value='js'>JS</option>
                <option value="php">PHP</option>
                <option value="html">HTML</option>
                <option value="css">CSS</option>
            </select><br>
            <label for="other">Other: </label><br>
            <input type="text" name="other" id="other" /><br>
            <input type="text" id="filename" name="fileName" placeholder="filename"/>
            <input type="file" name="file"/>
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" /> 
            <button type="submit" id="minify">Minify</button>
        </form>
        
        
    </body>
</html>

<?php
    }
    
?>
                
                
                
                
            

