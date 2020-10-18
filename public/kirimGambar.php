<?php

$base64_string = $_POST['image'];
$username = $_POST['idUser'];
$image_name = '/var/www/html/Pendik/storage/app/images/'.$username;





if (!file_exists($image_name)) {
 if (!mkdir($image_name)) {
    $m=array('msg' => "REJECTED, cant create folder");
    echo json_encode($m);
    return;}
}

$fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
$fileCount = iterator_count($fi)+1;
$data = explode(',', $base64_string);
$fullName = $image_name."/".$fileCount."_". date("YmdHis") .".png";
$ifp = fopen($fullName, "wb");
fwrite($ifp, base64_decode($data[1]));
fclose($ifp);
if (!$ifp){
    $m=array('msg' => "REJECTED, ".$fullName."not saved");
    echo json_encode($m);
    return;}

$command = escapeshellcmd("python checkImg.py ".$fullName);
$output = shell_exec($command);
$fi = new FilesystemIterator($image_name, FilesystemIterator::SKIP_DOTS);
$fileCount = iterator_count($fi);
$m = array('msg' => $output." total(".$fileCount.")");
echo json_encode($m);

?>
