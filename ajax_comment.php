<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostCommentDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$txt = filter_input(INPUT_POST, 'txt', FILTER_SANITIZE_SPECIAL_CHARS);

$array = [];

if ($id && $txt) {
    $postCommentDao = new PostCommentDaoMysql($pdo);

    $newComment = new PostComment();
    $newComment->id_post = $id;
    $newComment->id_user = $userInfo->id;
    $newComment->body = $txt;
    $newComment->created_at = date('Y-m-d H:i:s');

    $postCommentDao->addComment($newComment);

    $array = [
        'error' => '',
        'link' => $base . '/perfil.php?id=' . $userInfo->id,
        'avatar' => $base . '/media/avatars/' . $userInfo->avatar,
        'name' => $userInfo->name,
        'body' => $txt
    ];
}


header("content-Type: application/json");
echo json_encode($array);
exit();

