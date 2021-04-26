<?php

namespace CreatyDev\Http\Account\Controllers;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;

use CreatyDev\Domain\Account\Contest;

class ReportController extends Controller
{
    public function index()
    {
        $data = Contest::paginate(10);
        $table = [
            'fields' => [
                'title' => 'Event Title',
                'desc' => 'Description',
                'contest_type' => 'Contest Type',
                'start_date' =>'start_date',
                'end_date' => 'end_date',
            ],
            'action' => [
                'route_name_edit' => 'account.contest.edit',
                'route_name_delete' => '',
                'route_name_show' => 'account.contest.show',
                'key_name' => 'id', // 'id' by default
            ]
        ];
        $title = 'Contest';
        $titles = 'Contests';
        return view('account.reports.index', compact('data','title','titles','table'));
    }
}
