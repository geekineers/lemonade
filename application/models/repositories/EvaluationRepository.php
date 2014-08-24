<?php
use Evaluation as Evaluation;

class EvaluationRepository extends BaseRepository
{

    public function __construct()
    {
        $this->class = new Evaluation();

    }

    public function scheduleForEvaluation($employee_id, $data, $creator)
    {
        $post = array();
        $save = $this->create();
    }

}
