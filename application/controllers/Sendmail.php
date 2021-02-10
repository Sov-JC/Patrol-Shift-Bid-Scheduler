<?php

class Sendmail extends CI_Controller {    
    
    public function run(){
        echo "Running mail";
        $this->load->library('email');
        $this->email->from('sfscbids@gmail.com', 'SFSC Bids');
        $this->email->to('jcost043@fiu.edu');
        $this->email->subject('Bid notification');
        $this->email->message('It is your turn to bid on the patrol schedule. Please follow the instructions at <a href="http://www.example.com/">http://www.example.com/</a>.');
        $this->email->send();
        echo "Done running mail";
    }
    
}


?>