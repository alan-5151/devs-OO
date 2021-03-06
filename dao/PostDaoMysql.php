<?php

require_once 'models/Post.php';
require_once 'dao/UserRelationDaoMysql.php';
require_once 'dao/UserDaoMysql.php';
require_once 'dao/PostLikeDaoMysql.php';
require_once 'dao/PostCommentDaoMysql.php';

class PostDaoMysql implements PostDAO {

    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }

    public function insert(Post $p) {


        $sql = $this->pdo->prepare("INSERT INTO posts (id_user, type, created_at, body) VALUES (:id_user, :type, :created_at, :body)");
        $sql->bindValue(':id_user', $p->id_user);
        $sql->bindValue(':type', $p->type);
        $sql->bindValue(':created_at', $p->created_at);
        $sql->bindValue(':body', $p->body);
        $sql->execute();

        return true;
    }

    public function delete($id, $id_user) {

        $foto = [];
        $foto = $this->delPhotosFrom($id, $id_user);

        if ($foto) {
            $teste = $foto['body'];
            unlink("media/uploads/$teste");
        }
        
        $sql = $this->pdo->prepare("DELETE FROM posts WHERE id = :id AND id_user = :id_user LIMIT 1");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();


        $sql2 = $this->pdo->prepare("DELETE FROM postcomments WHERE id_post = :id_post");
        $sql2->bindValue(':id_post', $id);
        $sql2->execute();


        $sql3 = $this->pdo->prepare("DELETE FROM postlikes WHERE id_post = :id_post");
        $sql3->bindValue(':id_post', $id);
        $sql3->execute();
    }

    public function getUserFeed($id_user) {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM posts"
                . " WHERE id_user = :id_user"
                . " ORDER BY created_at DESC ");
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();



        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);


            // 3. Transformar o resultado em objetos
            $array = $this->_postListToObject($data, $id_user);
        }

        return $array;
    }

    public function getHomeFeed($id_user) {
        $array = [];
        // 1. Lista dos usuários que Eu sigo.
        $urDao = new UserRelationDaoMysql($this->pdo);
        $userList = $urDao->getFollowing($id_user);
        $userList[] = $id_user;

        // 2. Pegar os posts ordenado por data DESC
        $sql = $this->pdo->query("SELECT * FROM posts WHERE id_user IN (" . implode(',', $userList) . ") ORDER BY created_at DESC ");

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            // 3. Transformar o resultado em objetos
            $array = $this->_postListToObject($data, $id_user);
        }

        return $array;
    }

    public function getPhotosFrom($id_user) {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM posts"
                . " WHERE id_user = :id_user AND type = 'photo'"
                . " ORDER BY created_at DESC");
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();



        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            $array = $this->_postListToObject($data, $id_user);
        }

        return $array;
    }

    public function delPhotosFrom($id, $id_user) {
        $array = [];

        $sql = $this->pdo->prepare("SELECT type, body FROM posts"
                . " WHERE id = :id AND id_user = :id_user AND type = 'photo'"
                . " ORDER BY created_at DESC");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $array = $data;
        }

        return $array;
    }

    private function _postListToObject($post_list, $id_user) {
        $posts = [];
        $userDao = new UserDaoMysql($this->pdo);
        $postLikeDao = new PostLikeDaoMysql($this->pdo);
        $postCommentDao = new PostCommentDaoMysql($this->pdo);

        foreach ($post_list AS $post_item) {
            $newPost = new Post();
            $newPost->id = $post_item['id'];
            $newPost->type = $post_item['type'];
            $newPost->created_at = $post_item['created_at'];
            $newPost->body = $post_item['body'];
            $newPost->mine = false;

            if ($post_item['id_user'] === $id_user) {
                $newPost->mine = true;
            }

            // Pegar indormações do usuário

            $newPost->user = $userDao->findById($post_item['id_user']);


            // Informações sobre LIKE
            $newPost->likeCount = $postLikeDao->getLikeCount($newPost->id);
            $newPost->liked = $postLikeDao->isLiked($newPost->id, $id_user);


            // Informações sobre COMMENT
            $newPost->comments = $postCommentDao->getComments($newPost->id);

            $posts[] = $newPost;
        }

        return $posts;
    }

}
