		</div>
		<!-- /container -->
		<script src="<?= site_url('assets/js/jquery.min.js') ?>"></script>
		<script src="<?= site_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= site_url('assets/js/moment.min.js') ?>"></script>
        <script src="<?= site_url('assets/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
        
        <!-- for view_add_time_slot startTime -->
        <script type="text/javascript">
                    $(function () {
                        $('#datetimepicker3').datetimepicker({
                            format: 'LT'
                        });
                    });
        </script>  
        
        <!-- for view_add_time_slot startTime -->
        <script type="text/javascript">
                    $(function () {
                        $('#datetimepicker4').datetimepicker({
                            format: 'LT'
                        });
                    });
        </script>

        <script type="text/javascript">
            moment.updateLocale("en", {
                week: {
                    dow: 5
                }
            });

            $.extend($.fn.datetimepicker.Constructor.Default, {
                // format: "MM/DD/YYYY HHmm",
                icons: {
                    time: "fas fa-clock",
                    date: "fas fa-calendar",
                    up: "fas fa-arrow-up",
                    down: "fas fa-arrow-down",
                    previous: "fas fa-chevron-left",
                    next: "fas fa-chevron-right",
                    today: "fas fa-calendar-check-o",
                    clear: "fas fa-trash",
                    close: "fas fa-times"
                }
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $(function () {
                let date = <?= isset($date) ? "'" . $date . "'" : 'moment()' ?>;

                $('#schedule-date-picker').datetimepicker({
                    format: 'MM/DD/YYYY',
                    date: date
                });

                $('#schedule-date-picker').on("change.datetimepicker", function (e) {
                    location.href = "/schedule/day/" + encodeURIComponent(e.date.format("YYYY-MM-DD"));
                });
            });
        </script>
	</body>
</html>
