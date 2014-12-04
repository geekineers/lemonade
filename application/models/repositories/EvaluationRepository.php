<?php
use Evaluation as Evaluation;
use Respect\Validation\Validator as Validator;

class EvaluationRepository extends BaseRepository
{

    public function __construct()
    {

        $this->class = new Evaluation();

    }

    public function scheduleForEvaluation($employee_id, $data, $creator)
    {

        $validator = Validator::arr()->key('evaluation_name', Validator::notEmpty())
                                     ->key('employee_id', Validator::notEmpty())
                                     ->key('evaluation_description', Validator::notEmpty())
                                     ->key('evaluation_from', Validator::date('Y-m-d'))
                                     ->key('evaluation_to', Validator::date('Y-m-d'))
                                     ->validate($data);

        if ($validator) {

            $data['created_by'] = $creator;
            // dd($data);
            return $this->create($data);
        } else {
            return false;
        }
    }

    public function getMyEval($employee_id)
    {
        $current_date = date('Y-m-d');
        return $this->where('employee_id', '=', $employee_id)
                    ->where('evaluation_from', '>=', $current_date)
                    ->orderBy('evaluation_from', 'desc')
                    ->take(5)
                    ->get();
    }

}
