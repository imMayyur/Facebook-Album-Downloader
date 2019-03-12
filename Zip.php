<?php
class zip
{
   private $zip;
   public function __construct( $file_name, $zip_directory)
   {
        $this->zip = new ZipArchive();
        $this->path = dirname( __FILE__ ) . $zip_directory . $file_name . '.zip';
        $this->zip->open( $this->path, ZipArchive::CREATE | ZipArchive::OVERWRITE );
    }
      
   /**
     * Get the absolute path to the zip file
     * @return string
     */
    public function get_zip_path()
    {
        return $this->path;
    }   
       
    /**
     * Add a directory to the zip
     * @param $directory
     */
    public function add_directory( $directory )
    {
        if( is_dir( $directory ) && $handle = opendir( $directory ) )
        {
            $this->zip->addEmptyDir( $directory );
            while( ( $file = readdir( $handle ) ) !== false )
            {
                if (!is_file($directory . '/' . $file))
                {
                    if (!in_array($file, array('.', '..')))
                    {
                        $this->add_directory($directory . '/' . $file );
                    }
                }
                else
                {
                    $this->add_file($directory . '/' . $file);                }
            }
        }
    }
   
    /**
     * Add a single file to the zip
     * @param string $path
     */
    public function add_file( $path )
    {
        $this->zip->addFile( $path, $path);
    }
   
    /**
     * Close the zip file
     */
    public function save()
    {
        $this->zip->close();
    }


    public function removeRecursive($dir)
    {
        // Remove directories from the directory list
        $files = array_diff(scandir($dir), array('.','..'));

        // Delete all files one by one
        foreach ($files as $file) {
            // If current file is directory then recurse it
            (is_dir("$dir/$file")) ? $this->removeRecursive("$dir/$file") : unlink("$dir/$file");
        }

        // Remove blank directory after deleting all files
        return rmdir($dir);
    }
}

?>