<?php

namespace App\Repository\Eloquent;

use App\Models\Invoice;
use App\Repository\InvoiceRepositoryInterface;
use Illuminate\Support\Collection;

class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Invoice $model
     */
    public function __construct(Invoice $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}