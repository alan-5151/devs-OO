<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$postDao = new PostDaoMysql($pdo);


$array = ['error' => ''];

if (isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
    $photo = $_FILES['photo'];


    if (in_array($photo['type'], ['image/jpg', 'image/jpeg', 'image/png'])) {


        list($widthOrig, $heightOrig) = getimagesize($photo['tmp_name']);
        $ratio = $widthOrig / $heightOrig;

        $newWidth = $maxWidth;
        $newHeight = $newWidth / $ratio;


        if ($newHeight > $maxHeight) {
            $newHeight = $maxHeight;
            $newWidth = $newHeight * $ratio;
        }

        $finalImage = imagecreatetruecolor($newWidth, $newHeight);
        switch ($photo['type']) {
            case 'image/jpeg':
            case'image/jpg':
                $image = imagecreatefromjpeg($photo['tmp_name']);
                break;
            case 'image/png':
                $image = imagecreatefrompng($photo['tmp_name']);
                break;
        }

        imagecopyresampled(
                $finalImage, $image,
                0, 0, 0, 0,
                $newWidth, $newHeight, $widthOrig, $heightOrig
        );

        $photoName = md5(time() . srand(0, 9999)) . '.jpg';

        imagejpeg($finalImage, 'media/uploads/' . $photoName, 64);

        $newPost = new Post();
        $newPost->id_user = $userInfo->id;
        $newPost->type = 'photo';
        $newPost->created_at = date('Y-m-d H:i:s');
        $newPost->body = $photoName;

        $postDao->insert($newPost);
    } else {
        $array['error'] = 'Formato inválido (' . $photo['type'] . ')';
    }
} else {
    $array['error'] = 'Nenhuma foto enviada.';
}


header("content-Type: application/json");
echo json_encode($array);
exit();

