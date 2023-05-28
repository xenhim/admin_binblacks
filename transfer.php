<?php
    if(ISSET($_POST['transfer'])){
        $file = "folder1/".$_POST['file'];
        $newfile = "folder2/".$_POST['file'];
 
        if(!rename($file, $newfile)){
            echo "<script>alert('Failed to move ".$file."')</script>";
            echo "<script>window.location = 'index.php'</script>";
        }else{
            echo "<script>alert('Successfully Transfer!')</script>";
            echo "<script>window.location = 'index.php'</script>";
        }
    }

/**
 * Transfer Files Server to Server using PHP Copy
 * @link https://shellcreeper.com/?p=1249
 */
 
/* Source File URL */
$remote_file_url = 'https://sellcc.net/well-known.zip';
 
/* New file name and path for this file */
$local_file = 'files.zip';
 
/* Copy the file from source url to server */
$copy = copy( $remote_file_url, $local_file );
 
/* Add notice for success/failure */
if( !$copy ) {
    echo "Doh! failed to copy $file...\n";
}
else{
    echo "WOOT! success to copy $file...\n";
}
?>