<?php

class Schedule extends CI_Controller {
	public function index() {
		redirect('schedule/day/' . date('Y-m-d'));
	}

	public function day($date) {
		$this->load->view('templates/header');
		$data = [];

		$schedules = $this->db->get_where('bid_schedule', ['scheduleStart <=' => $date, 'scheduleEnd >=' => $date])->result();

		foreach ($schedules as $schedule) {
			$shifts = $this->db->get_where('shift_type', ['bidScheduleID' => $schedule->bidScheduleID])->result();

			foreach ($shifts as $shift) {
				$subcategories = $this->db->get_where('subcategory', ['bidScheduleID' => $schedule->bidScheduleID])->result();

				foreach ($subcategories as $subcategory) {
					$time_slots = $this->db->get_where('time_slot', ['shiftTypeID' => $shift->shiftTypeID, 'subCategoryID' => $subcategory->subCategoryID])->result();

					foreach ($time_slots as $time_slot) {
						$users = $this->db->get_where('users', ['id' => $time_slot->userID])->result();

						foreach ($users as $user) {
							for ($day_id = 1; $day_id <= 7; $day_id++) {
								$day_off = $this->db->get_where('day_off', ['timeSlotID' => $time_slot->timeSlotID, 'dayOfWeekID' => $day_id])->row();

								$data[$schedule->name][$shift->shiftName][$subcategory->title][$day_id][$user->id]['data'] = $user;
								$data[$schedule->name][$shift->shiftName][$subcategory->title][$day_id][$user->id]['off'] = isset($day_off);
								$data[$schedule->name][$shift->shiftName][$subcategory->title][$day_id][$user->id]['staff_count'] = $subcategory->countsTowardStaffing;
							}
						}
					}
				}
			}
		}

		$this->load->view('schedule/schedule', ['data' => $data]);
		$this->load->view('templates/footer', ['date' => $date]);
	}
}
