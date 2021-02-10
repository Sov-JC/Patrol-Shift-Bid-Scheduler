</div>

<div class="container-fluid">

	<div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <div class="input-group date" id="schedule-date-picker" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#schedule-date-picker"/>
                    <div class="input-group-append" data-target="#schedule-date-picker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
	</div>
	
	<?php if (empty($data)): ?>
		<p>No active schedules during for this date.</p>
	<?php endif; ?>

	<?php foreach ($data as $schedule_name => $schedule): ?>
		<h1 class="display-4 mb-3"><?= $schedule_name ?></h1>

		<?php foreach ($schedule as $shift_name => $shift): ?>
			<?php $staffing = array_fill(1, 7, 0); ?>
			<h1 class="mb-3"><?= $shift_name ?></h1>

			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Friday</th>
						<th>Saturday</th>
						<th>Sunday</th>
						<th>Monday</th>
						<th>Tuesday</th>
						<th>Wednesday</th>
						<th>Thursaday</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($shift as $subcategory_name => $subcategory): ?>
						<tr>
							<th><?= $subcategory_name ?></th>

							<?php foreach ([6, 7, 1, 2, 3, 4, 5] as $day): ?>
								<td>
									<ul class="list-group">
										<?php foreach ($subcategory[$day] as $user): ?>
											<?php $user_name = $user['data']->last_name . ', ' . $user['data']->first_name ?>

											<?php if ($user['off']): ?>
												<li class="list-group-item disabled"><?= $user_name ?></li>
											<?php else: ?>
												<li class="list-group-item list-group-item-primary"><?= $user_name ?></li>
												<?php $staffing[$day] += $user['staff_count']; ?>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
					<tr>
						<th>Staffing</th>

						<?php foreach ([6, 7, 1, 2, 3, 4, 5] as $day): ?>
						<td>
							<ul class="list-group">
								<?php if ($staffing[$day] >= 5): ?>
									<li class="list-group-item list-group-item-success"><?= $staffing[$day] ?></li>
								<?php else: ?>
									<li class="list-group-item list-group-item-danger"><?= $staffing[$day] ?></li>
								<?php endif; ?>
							</ul>
						</td>
						<?php endforeach; ?>
					</tr>
				</tbody>
			</table>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>
