<?php
namespace App\Exports;
use App\Models\Duevent;

use DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DuClubEventExport implements FromQuery,WithHeadings
{
    use Exportable;

    public function __construct(int $year)
    {
        $this->year = $year;
    }


    public function headings(): array{
        return [
              'id','invite','name','designation','dept','phone','year',
         ];
     }


   
     public function query()
     {
         return Duevent::query()
             ->leftJoin('duclubs', 'duclubs.id', '=', 'duevents.duclub_id')
             ->select([
                 'duclubs.id as ID',
                 'duevents.invite as Invite',
                 'duclubs.name as Name',
                 'duclubs.designation as Designation',
                 'duclubs.dept as Dept',
                 'duclubs.phone as Phone',
                 'duevents.year as Year',
             ])
             ->where('duevents.year', $this->year);
     }
}