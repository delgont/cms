<?php
namespace Delgont\Cms\Repository\Eloquent\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface EloquentRepositoryInterface
{

    public function all(array $attributes = ['*'], array $relations = []) : Collection;

    public function paginate(array $attributes = ['*'], array $relations = []) : LengthAwarePaginator;

    public function get($where = [], array $attributes = ['*'], array $relations = []) : Collection;

    public function search($term, array $attributes = ['*'], array $relations = []) : Collection;


    public function create(array $payload) : ?Model;

}