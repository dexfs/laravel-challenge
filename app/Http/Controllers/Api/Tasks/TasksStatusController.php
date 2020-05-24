<?php


namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;

class  TasksStatusController  extends Controller
{
    public function __invoke()
    {
        $id = request()->query('id', null);
        return response()->json(['data' => $this->datasource($id)->toArray()]);
    }

    private function datasource($id)
    {
        $dataSource = collect([
            [
                'id' => 'nova',
                'name' =>'Nova',
            ],
            [
                'id' => 'em_andamento',
                'name' =>'Em Andamento',
            ],
            [
                'id' => 'em_testes',
                'name' =>'Em Testes',
            ],
            [
                'id' => 'finalizada',
                'name' =>'Finalizada',
            ],
        ]);

        if ($id) {
            return $dataSource->where('id', $id);
        }

        return $dataSource;
    }

}
