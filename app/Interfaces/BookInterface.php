<?php

namespace App\Interfaces;

interface BookInterface
{
    public function searchBookByAuthor($request);
    public function getCategories();
    public function searchBookByCategory($request);
    public function searchBookByAuthorAndCategory($request);
    public function store($request);
}