<?php
$username = $_POST['idUser'];
$image_name = '/var/www/html/Pendik/storage/app/images/'.$username;


if (!file_exists($image_name)) 
{
    $m = array('msg' => "REJECTED,no data to train");
    echo json_encode($m);
    return;
}


$lock = ".train_lock";
if (file_exists($lock)) 
{   $m = array('msg' => "REJECTED, another user is training ..., please try again few minute ");
    echo json_encode($m);
    return;
}

$ifp = fopen($lock, "wb");
fwrite($ifp, $username);
fclose($ifp);
if (!$ifp){
    $m=array('msg' => "REJECTED, cant create lock file");
    echo json_encode($m);
    return;}

$fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
$fileCount = iterator_count($fi);
$command1 = escapeshellcmd("python doTrainToCSV.py ".$image_name);
$output1 = shell_exec($command1);
$command2 = escapeshellcmd("python doTrainToModel.py");
$output2 = shell_exec($command2);
$m = array('msg' => $output1." total(".$fileCount. ") has been trained ".$output2);
echo json_encode($m);
?>
