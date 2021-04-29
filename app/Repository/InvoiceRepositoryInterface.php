<?php
namespace App\Repository;

use Illuminate\Support\Collection;

interface InvoiceRepositoryInterface
{
    public function all(): Collection;
}