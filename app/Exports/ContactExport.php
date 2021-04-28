<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

// class ContactExport implements FromQuery
class ContactExport implements FromQuery, WithMapping, WithHeadings
// class ContactExport implements FromCollection
{
    use Exportable;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function query()
    {
        return Contact::query()->where(['user_id'=>$this->user_id]);
    }

    // public function collection()
    // {
    //     return Contact::all();
    // }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Mobile',
        ];
    }
    public function map($one): array
    {
        return [
            $one->full_name,
            $one->email,
            $one->phone,
            $one->mobile,
            // Date::dateTimeToExcel($one->created_at),
        ];
    }
}
