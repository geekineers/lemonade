<?php
use LeaveType as LeaveType;

class LeaveTypeRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new LeaveType();

	}

	/**
	 * [createType description]
	 * @param  [string] $name                 [name of type]
	 * @param  [string] $approval_seq         ['and', 'or', 'hierchy']
	 * @param  [array] $required_approval    [user_role_id array]
	 * @param  [int] $base_points          [description]
	 * @param  [string] $type_of_point_earnin [description]
	 * @return [type]                       [description]
	 */
	public function createType($name, $approval_seq, $required_approval, $base_points, $type_of_point_earning	 )
	{

		$required_approval = implode("|", $required_approval);		
		$save = $this->create(
				[
					'leave_type_name' => $name,
					'leave_type_approval_sequence' =>  $approval_seq,
					'leave_type_required_approval' =>  $required_approval,
					'leave_type_base_points' => $base_points,
					'leave_type_points_earning' => $type_of_point_earning,
				]
			);

		if($save)
		{
			return true;
		}

		return false;
	}

}