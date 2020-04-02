<?php

function getUserArticles($user_id, $article_id)
{
    if (!$user_id or !$article_id) {
        return null;
    }
    if (!($user = User::getUser($user_id))) {
        throw new AlertException("查無此帳號!", '/');
    }
    if (!($blog = $user->blog)) {
        throw new AlertException("帳號尚未有部落格!", '/');
    }
    if (!($article = $blog->getArticle($article_id))) {
        throw new AlertException("此帳號無此文章!", '/');
    }
    return $article;
}