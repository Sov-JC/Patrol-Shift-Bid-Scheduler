<!-- container -->
<div class="container">
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>
            
            <!-- alert messages -->
            <?php $this->load->view('templates/alerts'); ?>
            
            <h1> Manage bid schedules </h1> 
            <h3> <a href="<?php echo base_url();?>admin/shift_bid_create">Create a bidding schedule</a></h3><br>
            
            <?php 
            /*
            <div class="my-3 p-3 bg-light rounded shadow">
                <h4 class="border-bottom border-gray pb-2 mb-0">Closed bid schedules</h4>
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <a href="#"> <strong class="d-block text-gray-dark"><i class="fas fa-circle" style="color:green"></i> Manage open schedules</strong> </a>
                    Pause and unpause bidding schedule and change properties of a bid such as <br> the start and end date of the patrolling schedule.
                    </p>
                </div>
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <a href="#"><strong class="d-block text-gray-dark"><i class="fas fa-circle"></i> Bid order between subsections</strong></a>
                    Set the order that subsections will vote on. Ex. Seargeants first, CSI officers seconds, Patrol officers 3rd, etc.
                    </p>
                </div>                
            </div>
            */
            ?>
            
            
            
            <div class="mb-5 p-3 bg-light rounded shadow">               
                <h4 class="border-bottom border-gray pb-2 mb-0">Open bid schedules</h4>                
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <a href = ""><strong class="d-block text-gray-dark"><i class="fas fa-circle" style="color:purple"></i> Manage bids</strong></a>
                    View users that have voted, or vote for them instead, for bid schedules that are open for bidding.
                    </p>
                </div>
            </div>
            
            <div class="my-3 p-3 bg-light rounded shadow">
                <h4 class="border-bottom border-gray pb-2 mb-0">Modify</h4>
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <a href="#"> <strong class="d-block text-gray-dark"><i class="fas fa-circle" style="color:green"></i> Bid Schedules</strong> </a>
                    Change state of bidding schedule (such as paused, closed, or open) and change properties of a bid such as <br> the start and end date of the patrolling schedule.
                    </p>
                </div>
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <a href="#"><strong class="d-block text-gray-dark"><i class="fas fa-circle"></i> Bid order between subsections</strong></a>
                    Set the order that subsections will vote on. Ex. Seargeants first, CSI officers seconds, Patrol officers 3rd, etc.
                    </p>
                </div>                
            </div>
            
            <div class="mb-5 p-3 bg-light rounded shadow">
                <h4 class="border-bottom border-gray pb-2 mb-0">Info and Instructions</h4>
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <a href=""><strong class="d-block text-gray-dark"><i class="fas fa-circle" style="color:gray"></i> Steps in bid process</strong></a>
                    View the steps required to create and run a bidding schedule that<br>
                    can be voted on by users.
                    </p>
                </div>
                <?php
                /*
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">@username</strong>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                    </p>
                </div>
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&bg=6f42c1&fg=6f42c1&size=1" alt="" class="mr-2 rounded">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">@username</strong>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                    </p>
                </div>
                */
                ?>
            </div>
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

    </div>
</div> 
<!-- container/ !-->

