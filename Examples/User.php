<?php

namespace Sharkzt\Collections\Examples;

use Sharkzt\Collections\Collection\ArrayList;

/**
 * Class User
 */
class User
{
    /**
     * @var string
     */
    protected $userName;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var ArrayList|Article[]
     */
    protected $articles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayList(Article::class);
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return User
     */
    public function setUserName(string $userName): User
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param Article $article
     * @return User
     */
    public function addArticle(Article $article): User
    {
        $this->articles->add($article);

        return $this;
    }

    /**
     * @param iterable $articles
     * @return User
     */
    public function addArticles(iterable $articles): User
    {
        $this->articles->addAll($articles);

        return $this;
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function removeArticle(Article $article): bool
    {
        return $this->articles->remove($article);
    }

    /**
     * @param iterable $articles
     * @return bool
     */
    public function removeArticles(iterable $articles): bool
    {
        return $this->articles->removeAll($articles);
    }

    /**
     * @return ArrayList|Article[]
     */
    public function getArticles(): ArrayList
    {
        return $this->articles;
    }
}
