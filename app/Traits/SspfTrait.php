<?php

namespace App\Traits;

use App\Models\Tag;
use Carbon\Carbon;

trait SspfTrait
{
    use MessagesTrait;
    public function scopeApplySspf($query, $model, $request)
    {
        $model = new $model();
        $sortable =  $model->sortable;
        $filterable = $model->dates;
        $orderable = ["ASC", "DESC", "asc", "desc"];
        // Searching
        // dd($request['search']);
      
        if ($request->has('search') && !is_null($request['search'])) {
            $baseClass = class_basename($model);
            $query = $model::whereLike($searchable, $request['search'], $baseClass);
        }
        // Sorting
        if ($request->has('sort') && !is_null(trim($request['sort'])) && $request->has('order_by') && !is_null(trim($request['order_by']))) {
            $order_by = in_array($request['order_by'], $orderable) ? $request['order_by'] : "DESC";
            $sort_column = in_array($request['sort'], $sortable) ? $request['sort'] : "id";
            $query->orderBy($sort_column, $order_by);
        }
        // Filter
        if ($request->has('filter') && !is_null($request['filter'])) {
            $filters = json_decode($request['filter'], true);
            $query->where(function ($query) use ($filters, $sortable, $filterable) {
                // Apply filter for each values
                foreach ($filters as $column => $value) {
                    if (!is_array($value)) {
                        if (in_array($column, $filterable)) {
                            $new_date = [];
                            $dates = explode("to", $value);
                            $new_date[0] = Carbon::createFromFormat('Y-m-d', $dates[0])->startOfDay()->toDateTimeString();
                            $new_date[1] = Carbon::createFromFormat('Y-m-d', $dates[1])->endOfDay()->toDateTimeString();
                            $query->whereBetween($column, $new_date);
                        } else {
                            $query->where($column, $value);
                        }
                    } else if ($value !== "") {
                        if (in_array($column, $sortable)) {
                            $query->whereIn($column, $value);
                        }
                    }
                }
            });
        }
        // Tag
        $tags = json_decode($request->tags, true);
        if (!is_null($tags) && !empty($tags['tags'])) {
            $ids = Tag::whereIn("name", $tags['tags'])->join('taggables', 'tags.id', '=', 'taggables.tag_id')->get()->pluck('taggable_id')
                ->unique()->toArray();
            if (!empty($ids)) {
                $query->whereIn('id', $ids);
            }
        }
        // Pagination
        return ($request->has('page') && !is_null(trim($request['page'])) && $request->has('per_page') && !is_null(trim($request['per_page'])))
            ? $query->paginate($request['per_page'])
            : $query->paginate();
        // ? $query->simplePaginate($request['per_page'])
        // : $query->simplePaginate();
    }

    public function customSSPF($model, $collection, $request)
    {
        $model = new $model();
        $searchable = $model->sortable;
        $table = $model->getTable();
        $filterable = $model->dates;

        if ($request->get('is_light', false)) {
            return $model->select($model->light)->get();
        }

        if (!is_null($request['search'])) {
            $baseClass = class_basename($model);
            $collection = $model::whereLike($searchable, $request['search'], $baseClass);
        }

        

        if ($request->has('sort') && !is_null($request['sort']) && $request->has('order_by') && !is_null($request['order_by'])) {
            $order_by = in_array($request['order_by'], ["ASC", "DESC", "asc", "desc"]) ? $request['order_by'] : "DESC";
            $collection = $collection->orderBy($request['sort'], $order_by);
        }
        if ($request->has('filter') && !is_null($request['filter'])) {
            $filters = json_decode($request['filter'], true);
            $collection = $collection->where(function ($collection) use ($filters, $searchable, $filterable, $table) {
                // Apply filter for each values
                foreach ($filters as $column => $value) {
                    if (!is_array($value)) {
                        if (in_array($column, $filterable)) {
                            $new_date = [];
                            $dates = explode("to", $value);
                            $new_date[0] = Carbon::createFromFormat('Y-m-d', $dates[0])->startOfDay()->toDateTimeString();
                            $new_date[1] = Carbon::createFromFormat('Y-m-d', $dates[1])->endOfDay()->toDateTimeString();
                            $collection = $collection->whereBetween($table . '.' . $column, $new_date);
                        } else {
                            $collection = $collection->where($column, $value);
                        }
                    } else if ($value !== "") {
                        if (in_array($column, $searchable)) {
                            $collection = $collection->whereIn($column, $value);
                        }
                    }
                }
            });
        }
        // Tags
       

        return ($request->has('page') && !is_null(trim($request['page'])) && $request->has('per_page') && !is_null(trim($request['per_page'])))
            ? $collection->paginate($request['per_page'])
            : $collection->paginate();
    }
}
