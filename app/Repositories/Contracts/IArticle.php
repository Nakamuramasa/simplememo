<?php

namespace App\Repositories\Contracts;

interface IArticle
{
    public function applyTags($id, array $data);
}