<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script>
//Script for Clipboard
  function copyClipboard() {
    $('#copy-button').tooltip();
  var elm = document.getElementById('copy-input');
if(window.getSelection) {
    // other browsers

    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(elm);
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand("Copy");
    try {
      var success = document.execCommand('copy');
      if (success) {
        $('#copy-button').trigger('copied', ['Copied!']);
      } else {
        $('#copy-button').trigger('copied', ['Copy with Ctrl-c']);
      }
    } catch (err) {
      $('#copy-button').trigger('copied', ['Copy with Ctrl-c']);
    }

    // Handler for updating the tooltip message.
  $('#copy-button').bind('copied', function(event, message) {
    $(this).attr('title', message)
        .tooltip('_fixTitle')
        .tooltip('show')
        .attr('title', "Copy")
        .tooltip('_fixTitle');
  });
  
  }
}
	
	
 function copyClipboard1() {
    $('#copy-button1').tooltip();
  var elm = document.getElementById('copy-input1');
if(window.getSelection) {
    // other browsers

    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(elm);
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand("Copy");
    try {
      var success = document.execCommand('copy');
      if (success) {
        $('#copy-button1').trigger('copied', ['Copied!']);
      } else {
        $('#copy-button1').trigger('copied', ['Copy with Ctrl-c']);
      }
    } catch (err) {
      $('#copy-button1').trigger('copied', ['Copy with Ctrl-c']);
    }

    // Handler for updating the tooltip message.
  $('#copy-button1').bind('copied', function(event, message) {
    $(this).attr('title', message)
        .tooltip('_fixTitle')
        .tooltip('show')
        .attr('title', "Copy")
        .tooltip('_fixTitle');
  });
  
  }
}
</script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
	@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css");

 .xtitle{
 margin: 0;
line-height: 1.42857143;
font-family: Roboto;
font-style: normal;
font-weight: bold;
color: #FFFFFF
  
}

.xheader {
  background-color: #C80909 !important; 
}

  .await {
    font-size: 14px;
    color: #ffffff;
  }

  .await_payment {
    flex-grow: 3;

  }

  .x-flex {
    text-align: center;
    padding-top: 10px;
  }

  .conv_amt {
    font-family: Roboto;
    font-style: normal;
    font-weight: 800;
    font-size: 20px;
    line-height: 14px;
  }
  .conv_amt_original {
    font-family: Roboto;
    font-style: normal;
    font-weight: 800;
    font-size: 10px;
  }

  .conv_rate {
    font-family: Roboto;;
    font-style: normal;
    font-weight: normal;
	font-size:16px;
  }

  .empty_space {}

  .empty_space_2 {
    height: 10px;
  }

  .xbody {
    font-family: Roboto;
    font-style: normal;
	font-size:16px;
    font-weight: normal;
	background: rgba(0, 0, 0, 0.05) !important;
    padding:2rem !important;
  }
 

  .payment_box {
    background: #FFFFFF;
   	gap:10px;
    padding-top: 10px;
    height: 260px;
    margin-top: 20px;
  }

  .payment_box>div {
    margin: 0 auto;
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
    width: 90%;
     }
	
	.pay_box_acct{
       height: 70px !important;
   	}
	
	.pay_box2 {  margin: auto;
    text-align: center;
    font-size: 14px;
    overflow-x: hidden;
	align-content
	}

  .xfooter {
    justify-content: center !important;

  }

  .xbtn {
    font-family: Roboto;
    font-style: normal;
    font-weight: normal;
	font-size:16px;
	padding: .5rem 2rem !important;
    text-align: center;
    text-transform: capitalize;
    background: #C80909 !important;
    border-radius: 100px !important;
    border-color: #C80909 !important;
  }

  .xbtn:hover {
    background: #e31010 !important;
    border-radius: 100px !important;
    border-color: #e31010 !important;

  }
  
    .xbtn:focus {
    background: #e31010 !important;
    border-radius: 100px !important;
    border-color: #e31010 !important;

  }

  .modal-backdrop {
    display: none;
  }

  .modal-tnb {
    background-color: #00000080;
  }

  @media screen and (min-width: 676px) {
    .modal-dialog {
      max-width: 350px;
      /* New width for default modal */
    }
  }

  .tnb-loader {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: rgb(241 242 243 / 62%);
    top: 0;
    padding-top: 50%;
    display: none;
  }

  .modal-dialog-tnb {
    position: relative
  }
	
	.xbtn_copy {
  border: none;  
background-color:transparent !important;
  padding:0px !important;
  }

.xbtn_copy:hover {
color: #C80909;
	background-color:transparent !important;
	}
</style>


<!-- Modal -->
<div class="modal modal-tnb" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-tnb">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header xheader">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h3 class="modal-title xtitle">TnbPay</h3>
        <div class="await ">
          <div class="timer" id="tnb_timer"> </div>
        </div>
      </div>



      <div class="d-flex flex-column x-flex">
        <div class="p-2 conv_amt_original"><?php echo (esc_html(isset($original) ? $original.'TNBC' : '')); ?></div>
        <div class="p-2 conv_amt"><?php echo (esc_html($price)); ?> TNBC</div>
        <!-- <div class = "p-2 empty_space">  </div> -->
        <div class="p-2 conv_rate">1TNBC = $<?php echo (esc_html($rate)) ?></div>
        <div class="p-2 empty_space_2"> </div>

      </div>

      <div class="modal-body  text-center xbody" > 
        Send the above amount to the account below using the memo as description 

        <div class="payment_box d-flex flex-column x-flex">

          <div class="p-2 pay_det"> Account </div>
			
          <div class="p-2 pay_box pay_box_acct d-flex flex-row ">
			  
			  <div class="pay_box2 " id ="copy-input" > <?php echo (esc_html($store_address)); ?> </div><button type="button" id="copy-button" onclick="copyClipboard()" class="btn-clipboard xbtn_copy" data-toggle="tooltip"  data-placement="bottom" title="Copy" > <i class="bi bi-clipboard fa-lg"></i> </button></div>

          <div class="p-2 pay_det"> Memo </div>
			  <div class="p-2 pay_box d-flex flex-row ">
          <div class="pay_box2" id ="copy-input1"> <?php echo (esc_html($meta)); ?> </div><button type="button" id="copy-button1" onclick="copyClipboard1()" class="btn-clipboard xbtn_copy" data-toggle="tooltip"  data-placement="bottom" title="Copy" > <i class="bi bi-clipboard fa-lg"></i> </button></div>



        </div>


      </div>
      <div class="modal-footer xfooter">
        <button type="button" id="paymentVerify" class="btn btn-primary btn-lg xbtn">Payment Made, Next</button>

      </div>
    </div>

    <div class="tnb-loader" id="tnbLoader">
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; display: block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" r="0" fill="none" stroke="#1c4595" stroke-width="2">
          <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="0s"></animate>
          <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="0s"></animate>
        </circle>
        <circle cx="50" cy="50" r="0" fill="none" stroke="#e76a24" stroke-width="2">
          <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-0.5s"></animate>
          <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-0.5s"></animate>
        </circle>
      </svg>
    </div>



  </div>
</div>


<script type="text/javascript">
  // jQuery(window).on('load', function() {
  //   jQuery('#exampleModal').modal({
  //     backdrop: 'static',
  //     keyboard: false
  //   });
  // });
  function tnbpayShortcodePopup(){
    jQuery('#exampleModal').modal({
      backdrop: 'static',
      keyboard: false
    });
  }
</script>
