<h1> Open schedule <?= $bid_schedule->name ?> overview </h1>

<?php $this->load->view('templates/alerts');?>    

<?php if($bid_made): ?>
    <p class = "text-success">
        Our system has successfully recorded your bid for this schedule.<br>
        Thanks for making a bid!
    </p>
<?php else: ?>
   
        <b>Is it my turn to bid?</b>
        
        <?php if($turn_to_bid): ?>
        <p>
            Yes, it is your turn to bid. Please click the "Continue" button below to <br>
            view spots available and make a bid.
        </p> 

        <p>
            <a 
              class="btn btn-primary" 
              href="<?= site_url("user/bid_on_time_slot/$bid_schedule->bidScheduleID") ?>" 
              role="button"
            >
                Continue
            </a>
        </p>

        <?php else: ?>  
            <p>
            No, the bidding process is still recording bids and has not caught up to you yet.<br>
            You will see a different message in this page when it is your turn to make a bid. <br>
            Additionally we will send you an email when it is your turn to bid.
            </p>
        <?php endif; ?>
       
<?php endif; ?>

<p> 
    Below is the bid status information of users in your subcategory for this schedule.
</p>

<table class = "table">
    <thead>
       <tr>
           <th>First</th>
           <th>Last</th>
           <th>Bid made</th>
           <th>Turn Number</th>
       </tr>        
    </thead>
    <tbody>
        
              
        <?php foreach($users_in_subcategory as $user): ?>
            <tr>
                <td>
                    <?= $user->first_name ?>
                </td>
                <td>
                    <?= $user->last_name ?>
                </td>
                <td>
                   <?php 
                    //utn_join_users is a join between users and user_turn_notice for 
                    //users belonging to this schedule
                    ?>
                    <?php foreach($utn_join_users as $utn_user): ?>
                        <?php if($utn_user->id == $user->id): ?>
                            <?= $utn_user->bidMade == 0 ? 'No' : 'Yes' ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
                <td>
                    <?php foreach($utn_join_users as $utn_user): ?>
                        <?php if($utn_user->id == $user->id): ?>
                            <?= $utn_user->turnNumber ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody> 
</table>

  

   

   
   
   
    
    
    
    
