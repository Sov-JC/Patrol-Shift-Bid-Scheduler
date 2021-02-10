

<!-- container -->
<div class="container">
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>
            
            <!-- form -->
            <form action="#">
            <div class = "bidding-period border-top border-right">
                <h3>Length of the bidding process</h3>
                <small>This is how long the bidding process will last. <br>
                Click <a href="">here</a> if you'd like to get an estimate on how long <br>
                it should be and on what days it's recommended that you start and end it.
                </small>
                <div class="form-group row">
                    <label for="example-date-input" class="col-2 col-form-label">Start Date: </label>
                    <div class="col-4">
                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-date-input" class="col-2 col-form-label">End Date: </label>
                    <div class="col-4">
                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                    </div>
                </div>
            </div>
            
            <div class = "schedule period border-top border-right">
                <h3>Length of the patrolling schedule</h3>
                <small> This is how long the patrolling schedule will last. Usually several months long.</small>
                <div class="form-group row">
                    <label for="example-date-input" class="col-2 col-form-label">Start Date: </label>
                    <div class="col-4">
                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-date-input" class="col-2 col-form-label">End Date: </label>
                    <div class="col-4">
                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                    </div>
                </div>                
            </div>
            
            <button type="submit" class="btn btn-success">Create</button>
            </form>
            <!-- /form -->          


            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

    </div>
</div> 
<!-- container/ !-->

