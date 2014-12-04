<?php

abstract class BaseRepository
{

    protected $currentModel;
    protected $validator;
    protected $class;

    public function create(array $input)
    {
        // dd($input);
        return $this->currentModel = $this->class->create($input);
        
    }

    public function update(array $input, $id)
    {
        $this->currentModel = $this->class->withTrashed()->findOrFail($id);

        $this->currentModel->update($input);

        return $this->currentModel;
    }

    public function delete($id)
    {
        $this->currentModel = $this->class->findOrFail($id);

        return $this->currentModel->delete();
    }

    public function getCurrentModel()
    {
        return $this->currentModel;
    }

    public function getClassName()
    {
        return $this->class;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function restoreDeleted($id)
    {
        $model = $this->class->onlyTrashed()->findOrFail($id);

        return $model->restore();
    }

    public function find($id)
    {
        return $this->class->find($id);
    }

    public function findOrFail($id)
    {
        return $this->class->findOrFail($id);
    }

    public function findOrFailWithTrashed($id)
    {
        return $this->class->withTrashed()->findOrFail($id);
    }

    public function all()
    {
        return $this->class->all();
    }

    public function limit($start, $limit)
    {
        return $this->class->skip($start)->take($limit);
    }

    public function with($relationship)
    {
        return $this->class->with($relationship);
    }

    public function withTrashed()
    {
        return $this->class->withTrashed();
    }

    public function whereBetween($column, $values, $boolean = "and", $not = false)
    {
        return $this->class->whereBetween($column, $values, $boolean, $not);
    }

    public function withTrashedRelationship(array $relationship)
    {
        $rel = [];

        foreach ($relationship as $relationshipName) {
            $rel[$relationshipName] = function ($query) {
                $query->withTrashed();
            };
        }

        return $this->with($rel);
    }

    public function paginate($limit)
    {
        return $this->class->paginate($limit);
    }

    public function where($column, $operator = null, $value = null)
    {
        return $this->class->where($column, $operator, $value);
    }

    public function orWhere($column, $operator = null, $value = null)
    {
        return $this->class->orWhere($column, $operator, $value);
    }

    public function whereIn($column, $values,  $boolean = 'and', $not = false)
    {
        return $this->class->whereIn($column,$values, $boolean,$not);
    }

    public function whereHas($relation, $callback, $operator = ">=", $count = 1)
    {
        return $this->class->whereHas($relation, $callback, $operator, $count);
    }

    public function orderBy($column, $order)
    {
        return $this->class->orderBy($column, $order);
    }

    public function groupBy($group)
    {
        return $this->class->groupBy($group);
    }

    public function onlyTrashed()
    {
        return $this->class->onlyTrashed();
    }

    public function whereRaw($sql, $array_binding)
    {
        return $this->class->whereRaw($sql, $array_binding);
    }
    public function whereNotBetween($column, $values, $boolean = 'and'){
        return $this->class->whereNotBetween( $column, $values, $boolean);
   }



}
