<?php
use Respect\Validation\Validator as Validator;
use Training as Training;

class TrainingRepository extends BaseRepository
{

    public function __construct()
    {
        $this->class = new Training();

    }
    /**
     * Save Training
     * @param  [array] $data [array['name', 'description', 'from', 'to']]
     * @return [boolean]       [description]
     */
    public function saveTraining($data)
    {
        $validator = Validator::arr()->key('name', Validator::notEmpty())
                                     ->key('from', Validator::date('Y-m-d'))
                                     ->key('to', Validator::date('Y-m-d'))
                                     ->validate($data);

        if ($validator) {

            // dd($data);
            return $this->create($data);

        }
    }

    public function deleteTraining($data)
    {
        $id            = $data['id'];
        $training_name = $data['name'];
        return $this->delete($id);

    }

}
