<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TaskExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $task = DB::table('tasks')
                    ->leftJoin('users', 'tasks.assigned_to', '=', 'users.id_user')
                    ->leftJoin('users as created_user', 'tasks.created_by', '=', 'created_user.id_user')
                    ->select('tasks.id','tasks.task_category', 'tasks.task_type', 'tasks.description', 'tasks.source', 'tasks.due_date', 'tasks.status', 'users.name', 'created_user.name as created_user')
                    ->where(function ($query) {
                        $query->whereNull('tasks.deleted_at')
                            ->orWhere('tasks.deleted_at', '');
                    })
                    ->get();
        //return Task::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Task Category',
            'Type',
            'Description',
            'Source',
            'Due Date',
            'Status',
            'Assigned To',
            'Assigned By',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold
            1 => ['font' => ['bold' => true]],
        ];
    }
}
