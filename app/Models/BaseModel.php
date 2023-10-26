<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $hidden = [
        'deleted_at'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function queryFilter($request): array
    {
        $modelQuery = self::when(
            array_key_exists('meta', $request),
            function ($query) use ($request) {
                $select = [];
                foreach ($request['meta'] as $field) {
                    if (in_array($field, self::getFillable(), true)) {
                        $select[] = $field;
                    }
                    if (array_key_exists($field, self::getRelations())) {
                        $query->with(self::getRelations()[$field]);
                    }
                }
                $query->select($select);
            },
            function ($query) {
                $query->select('*');
            }
        )
            ->when(!array_key_exists('meta', $request), function ($query) {
                $new = new self();
                foreach ($new->getRelations() as $rel) {
                    $query->with($rel);
                }
            }
            );

        $total = $modelQuery->count();
        $models = $modelQuery->offset(($request['page'] - 1) * $request['size'])
            ->limit($request['size'])
            ->get();

        return [
            'result' => $models,
            'total' => $total,
        ];
    }
}
