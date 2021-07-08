<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap') ;

.modal-title {

font-family: Roboto;
font-style: normal;
font-weight: bold;
color: #FFFFFF
  
}

.modal-header {
  background-color: #C80909; 
}

.await {
  font-size: 14px;
  color:#ffffff;
}

.await_payment {
flex-grow: 3 ;

}

.d-flex {
  text-align: center;
	padding-top:10px;
}

.conv_amt {
font-family: Roboto;
font-style: normal;
font-weight: 800;
font-size: 20px;
line-height: 16px;
}

.conv_rate {
font-family: Roboto;
font-style: normal;
font-weight: normal;
}

.empty_space {
 
}

.empty_space_2 {
  height: 10px;
}

.modal-body {
font-family: Roboto;
font-style: normal;
font-weight: normal;
background: rgba(0, 0, 0, 0.05);
padding-top:  12px;
}

.payment_box {
background: #FFFFFF;
display: flex;
flex-direction: column;
padding-top:10px;
height:210px;
margin-top: 20px;
}
	
	.payment_box > div {
	margin:0 auto;
	}
	
.pay_det {
font-family: Roboto;
font-style: normal;
font-weight: bold;
font-size: 18px;
text-align: center;
text-transform: capitalize;
}

.pay_box {
  background: rgba(0, 0, 0, 0.05);
  height: 40px;
  width:90%;
   margin: auto;
  text-align: center;
  font-size:14px;
  white-space: nowrap;
  overflow:hidden;

}

.modal-footer {
        display: flex;
        align-items: center;
        justify-content: center;

}

.btn {
font-family: Roboto;
font-style: normal;
font-weight: normal;
text-align: center;
text-transform: capitalize;
background: #C80909;
border-radius: 100px;
border-color: #C80909;
}

.modal-backdrop{
  display: none;
}

	 @media screen and (min-width: 676px) {
        .modal-dialog {
          max-width: 350px; /* New width for default modal */
        }
    }
</style>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h5 class="modal-title">TnbPay</h5>
          <div class = "await "> 
           <div class="timer" id="tnb_timer">  </div>
        </div> </div>
    
     

        <div class = "d-flex flex-column"> 
            <div class="p-2 conv_amt"><?php echo( esc_html($price) ); ?> TNB</div> 
           <!-- <div class = "p-2 empty_space">  </div> -->
            <div class="p-2 conv_rate">1TNB = $<?php echo( esc_html($rate)) ?></div>
             <div class = "p-2 empty_space_2">  </div>

         </div>

        <div class="modal-body text-center">
          Send the above amount to the account below using the memo as description
			
               <div class ="payment_box d-flex flex-column" > 
				   
                    <div class = "p-2 pay_det"> Account </div>
                    <div class = "p-2 pay_box "> <?php echo( esc_html($store_address) ); ?></div>

                    <div class = "p-2 pay_det"> Memo </div>
                     <div class = "p-2 pay_box"> <?php echo( esc_html($meta) ); ?> </div>
                     


               </div>


        </div>
        <div class="modal-footer">
          <button type="button" id="paymentVerify" class="btn btn-primary btn-lg">Payment Made, Next</button>
      
    </div>
  </div>



                </div>
            </div>


            <script type="text/javascript">
                jQuery(window).on('load',function(){
                  jQuery('#exampleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                  });
                });
            </script>
