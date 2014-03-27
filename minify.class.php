<?php
class MINIFY{
    
    public $unminified;
    public $minified;
    
    function readFile($code){
        $this->minified = str_ireplace(array("\r", "\n"), '', $code);
        return $this->minified;
        
    }
    
    function fromFile($file){
       $this->unminified = file_get_contents($file);
       //return $this->unminified;
       $this->minified = str_ireplace(array("\r", "\n"), '', $this->unminified);
    }
    
    
    
    function toFile($file){
       //$this->minified = str_ireplace(array("\r", "\n"), '', $this->unminified);
       $newFile = $this->minified;
       $handle = fopen($file, 'w+');
       fputs($handle, $newFile);
       fclose($handle);
       
    }
    
    function browserDL($file){
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        $output = fopen("php://output", "w");
        //$this->minified = str_ireplace(array("\r", "\n"), '', $this->unminified);
        $newFile = $this->minified;
        fputs($output, $newFile);
    }


    function commandMinify($file, $destFile){
        $this->fromFile($file);
        $this->toFile($destFile);
    }


}
?>