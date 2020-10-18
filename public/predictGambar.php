<?php
$realpath = '/var/www/html/Pendik/storage/app/images/PREDICT_';
$base64_string = $_POST['image'];
$username = $_POST['idUser'];
$image_name = $username;


$image_name =  $realpath.$username;
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
$command = escapeshellcmd("python doPredict.py " .$username." " .$fullName);
$output = shell_exec($command);
$m = array('msg' => $output);
echo json_encode($m);
?>
