<?php

namespace Application\Models;

use Application\Model;
use Application\Models\User;
use Application\Db;
use Application\Core\MultiException;

class Article extends Model {

    const TABLE = 'blog_articles';

    public $title;
    public $content;
    public $id_user;

    public function __get($key) {
        if ('author' == $key) {
            $id_user = $this->id_user;
            if (!empty($id_user)) {
                $db = Db::instance();
                $author = User::findById($id_user);
                $name = $author->login;
                return ($name) ? $name : 'Без автора';
            } else {
                return 'Без автора';
            }
        }
    }

    public function __isset($key) {
        if ('author' == $key) {
            return !empty($this->id_user);
        } else {
            return false;
        }
    }

    public function __set($key, $value) {
        $e = new MultiException();
        if ('author' === $key) {
            if ($author = User::findByName($value)) {
                $this->author_id = $author->id;
            } else {
                $this->author_id = null;
                $e[] = new \Exception('В базе данных отсутствует пользователь с таким именем.');
            }
        } else {
            $e[] = new \Exception('Вы пытаетесь сохранить данные с несуществующим ключом: ' . $key);
        }
    }

    public function getTags() {
        $db = Db::instance();
        $sql = "SELECT tags.id, tags.name FROM blog_articles_tags INNER JOIN tags ON (tags.id = articles_tags.id_tag) WHERE blog_articles_tags.id_article = :id_article";
        $res = $db->query($sql, "Application\Models\Tag", [':id_article' => $this->id]);

        return $res;
    }

    public function saveTags($arrTags) {
        $db = Db::instance();
        $sql = 'DELETE FROM blog_articles_tags WHERE id_article = :id_article';
        $db->execute($sql, [':id_article' => $this->id]);

        if (count($arrTags) > 0) {
            foreach ($arrTags as $tag) {
                $sql = 'INSERT INTO blog_articles_tags (id_article, id_tag) VALUES(:id_article, :tag)';
                $db->execute($sql, [':id_article' => $this->id, ':tag' => $tag]);
            }
        }
    }

    public function getIntro($length = 300) {
        return substr($this->content, 0, $length) . '...';
    }

}
