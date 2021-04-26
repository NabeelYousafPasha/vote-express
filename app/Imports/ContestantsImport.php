<?php

namespace CreatyDev\Imports;

use CreatyDev\Domain\Account\Contestant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContestantsImport implements ToModel, WithHeadingRow
{

    private $contest_id; 

    public function __construct($data)
    {
        $this->contest_id = $data; 
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contestant([
            'name'     => $row['name'],
           'email'    => $row['email'], 
           'phone'    => $row['phone'],
        //    'avatar'    => $row['avatar'], 
           'contest_id' => $this->contest_id,
           'votes'    => $row['votes']?$row['votes']:0, 
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
