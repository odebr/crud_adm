<?php

namespace App\Services;

use App\Post;
use App\Repository\InvoiceRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceService
{
    /**
     * @var InvoiceRepositoryInterface
     */
    private $repo;

    public function __construct(InvoiceRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return $this->repo->all();
    }

}