<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent {

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array  $attributes
	 * @return \Illuminate\Database\Eloquent\Model|static
	 */
	public static function create(array $attributes)
	{
		$model = new static($attributes);
		$model->company_id = 1;
		$model->save();

		return $model;
	}

	/**
	 * Get a new query builder for the model's table.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder|static
	 */
	public function newQuery()
	{
		$builder = $this->newEloquentBuilder(
			$this->newBaseQueryBuilder()
		);

		// Once we have the query builders, we will set the model instances so the
		// builder can easily access any information it may need from the model
		// while it is constructing and executing various queries against it.
		$builder->setModel($this)->with($this->with);

		return $this->applyGlobalScopes($builder)->where('company_id', 1);
	}

}	
