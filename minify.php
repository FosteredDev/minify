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

<?php 

$pageTitle = "Fostered Development - Minify";
$description = "Minify is a simple file minifier for HTML, CSS, jQuery/JavaScript, PHP and just about anything else";
$keywords = "jQuery, sliders, slideshow, jQuery plugin, jquery slideshow, jquery slider, javascript slider, javascript, javascript plugin"
        . "javascript slideshow, image slider, jquery image slider, image slideshow, jquery image slideshow, javascript image slider, javascript image slideshow";
$header = $_SERVER['DOCUMENT_ROOT'];
$header .= "/includes/header.php";

include($header);

?>

<div id="bodyWrapper">
        <form id="minifier" action="" method="post" enctype="multipart/form-data">
            
            <textarea id="unmin" name="unmin" rows="30" cols="100"></textarea>
            <div id="min_field_wrapper">
            <select form="minifier" name="fileType">
                <option>--Filetype--</option>
                <option value='js'>JS</option>
                <option value="php">PHP</option>
                <option value="html">HTML</option>
                <option value="css">CSS</option>
            </select>
            <label for="other">Other: </label>
            <input type="text" name="other" id="other" />
            <input type="text" id="filename" name="fileName" placeholder="filename"/>
            <input type="file" name="file"/>
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" /> 
            <button type="submit" id="minify">Minify!</button>
            </div>
        </form>
</div>      
        
    </body>
</html>

<?php
    }
    
?>
                
                
                
                
            

