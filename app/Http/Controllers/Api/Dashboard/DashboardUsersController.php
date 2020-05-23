<?php


namespace App\Http\Controllers\Api\Dashboard;

use App\Task;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class DashboardUsersController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'data' => $this->formatResponse(Task::groupedTasksByUsers(Carbon::now()->month)
                ->get()),
        ]);
    }

    private function formatResponse($data)
    {
        return $data->map(function ($item) {
            return [
                'total' => $item->total,
                'user'  => $item->user->name,
            ];
        });
    }
}
