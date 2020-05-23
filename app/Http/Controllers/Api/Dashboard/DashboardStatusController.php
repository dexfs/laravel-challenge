<?php


namespace App\Http\Controllers\Api\Dashboard;

use App\Task;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


class DashboardStatusController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'data' => Task::groupedTasksByStatus(Carbon::now()->month)
                ->get(),
        ]);
    }
}
