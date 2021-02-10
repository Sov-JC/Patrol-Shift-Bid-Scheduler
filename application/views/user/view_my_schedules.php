<h1> My schedules </h1>

<p> The schedules below are schedules you've been assigned to by your supervisors. </p>


<div id="open_schedules">
    <h5><span class="badge badge-info">Open</span> Schedules</h5>
    <p>
        Open schedules are schedules that are open for bidding.<br>
        Click on an open schedule below to:<br>
        - Make a bid (if you've been notified by email)<br>
        - View bidding progress<br>
        <?php foreach($open_schedules as $open_schedule): ?>
        <a href = "<?= site_url("user/view_my_open_schedule/".$open_schedule->bidScheduleID) ?>">
            <?= $open_schedule->name ?>
        </a> <br>
        <?php endforeach; ?>
    </p>
    
    
</div>


<div id="closed_schedules">
    <h5><span class="badge badge-success">Closed</span> Schedules</h5>
    <p>
        Closed schedules are schedules that are no longer accepting bids<br>
        because all users have already made their bid.<br>
        Click on a closed schedule below to:<br>
        - View p-sheets<br>
        - View shift-lineup<br>
        - Request days off<br>
        - Sign up for overtime (when available)<br>
        <?php foreach($closed_schedules as $closed_schedule): ?>        
        <a href = "<?= site_url("user/view_my_closed_schedule/".$closed_schedule->bidScheduleID) ?>">
            <?= $closed_schedule->name ?>
        </a> <br>
        <?php endforeach; ?>
    </p>
</div>
