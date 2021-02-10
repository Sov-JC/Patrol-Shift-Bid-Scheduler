<div class = "form-group">
                <?php echo //form_open("admin/schedule_add_time_slot/$bid_schedule_id"); ?>
                    <label for="startTime">Start time:</label>
                    <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                    </div>
                    </div>
                    <small class="form-text text-muted">The time the employee will start patrolling </small> 
                    <!-- script to make the input box show the time only--> 
                    <script type="text/javascript">
                        $(function () {
                            $('#datetimepicker3').datetimepicker({
                                format: 'LT',
                                icons: {
                                    time: 'far fa-clock',
                                    date: 'far fa-calendar-alt',
                                    up: 'fas fa-arrow-up',
                                    down: 'fas fa-arrow-down',
                                    previous: 'fas fa-chevron-left',
                                    next: 'fas fa-chevron-right',
                                    today: 'far fa-calendar-check',
                                    clear: 'far fa-trash-alt',
                                    close: 'fas fa-times'
                                }
                            });
                        });
                    </script>
                    
                <?php echo //form_close(); ?>
            </div>