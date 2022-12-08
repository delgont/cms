<?php
namespace Delgont\Cms\Repository\Eloquent;

use Delgont\Cms\Repository\Eloquent\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;
    protected $pagination = 15;
    protected $singleModelAttributes = [];

    public function __construct(Model $model){
        $this->model = $model;
    }


    public function all(array $attributes = ['*'], array $relations = []) : Collection
    {
        return $this->model->with($relations)->get($attributes);
    }


    public function paginate(array $attributes = ['*'], array $relations = []) : LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($this->pagination, $attributes);
    }

    public function get($where = [], array $attributes = ['*'], array $relations = []) : Collection
    {
        return $this->model->where($where)->with($relations)->get($attributes);
    }


    public function find($id, array $attributes = ['*'], $relations = []) : ? Model
    {
        return $this->model->select((count($this->singleModelAttributes) > 0) ? $this->singleModelAttributes : $attributes)->with($relations)->where((is_array($id)) ? $id : ['id' => $id])->firstOrFail();
    }

    public function create(array $payload) : ?Model
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    public function search($term, array $attributes = ['*'], array $relations = []) : Collection
    {
        return $this->model->with($relations)->search($term)->get($attributes); 
    }

    public function paginatedSearch($term, array $attributes = ['*'], array $relations = []) : LengthAwarePaginator
    {
        return $this->model->with($relations)->search($term)->paginate($this->pagination, $attributes); 
    }



}