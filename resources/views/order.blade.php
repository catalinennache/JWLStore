@extends('layouts.base')

@section('page_content')
<div class="container">
    <div class="row">
<div class="col-md-12 p-lg-3" style="margin-top:20px;">
    <h2 class="h3 mb-3 text-black">Order #<?php echo $order->AWB;?></h2>
    <div class="">
      
   <style>
    html,body{
        position: absolute;
        width:100%;
        height:100%;
    }
.invoice-box {
    
    height: 80%;
    display: block;
    margin: auto;
    padding: 30px;
  
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    font-size: 16px;
    line-height: 24px;
    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    color: #555;
    margin-bottom: 20px;
}

.invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
}

.invoice-box table td {
    padding: 5px;
    vertical-align: top;
}

.invoice-box table tr td:nth-child(2) {
    text-align: right;
}

.invoice-box table tr.top table td {
    padding-bottom: 20px;
}

.invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
}

.invoice-box table tr.information table td {
    padding-bottom: 40px;
}

.invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
}

.invoice-box table tr.details td {
    padding-bottom: 20px;
}

.invoice-box table tr.item td{
    border-bottom: 1px solid #eee;
}

.invoice-box table tr.item.last td {
    border-bottom: none;
}

.invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee;
    font-weight: bold;
}

@media only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
    }
    
    .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
    }
}

/** RTL **/
.rtl {
    direction: rtl;
    font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
}

.rtl table {
    text-align: right;
}

.rtl table tr td:nth-child(2) {
    text-align: left;
}
.tm{
    text-transform: uppercase;
    text-decoration: none;;
letter-spacing: .2em;
font-size: 20px;
padding-left: 10px;
padding-right: 10px;
border: 2px solid #25262a;
color: #000 !important;
}
</style>
</head>

<body>

<h2 class="h3 mb-3 text-black" style="  margin-top: 50px;">Factura</h2>              
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title stie_logo">
                            <a href="localhost:8000" class="tm js-logo-clone">Silver Boutique</a>  </td>
                        
                        <td>
                        Factura #: {{$invoice->invoice_number}}<br>
                            Creata: {{$invoice->invoice_date}}<br>
                           
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            Silver Boutique<br>
                            Adresa<br>
                            Bucuresti, 1234
                        </td>
                        
                        <td>
                           
                        {{$invoice->first_name}} {{$invoice->last_name}}<br>
                           {{$invoice->email}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr class="heading">
            <td>
                Modalitate de plata
            </td>
            
            <td>
                {{$invoice->payment_method==1?"CARD":"RAMBURS"}}
            </td>
        </tr>
        
       
        <tr class="heading">
            <td>
                Produs
            </td>
            
            <td>
                Pret
            </td>
        </tr>
        <?php $total = 0; $i = 0; foreach ($ordered_items as $oi) {
            ?>
        <tr class="item" >
            <td>
               {{$oi->product_name}} {{$oi->size_desc}}
            </td>
            
            <td>
               <?php $i++; $total += $oi->product_price; echo $oi->product_price; ?> Lei
            </td>
        </tr>
    <?php } ?>

    <tr class="item last" >
        <td>
           {{$shipment->courier}}
        </td>
        
        <td>
           <?php  $total += $shipment->shipping_price; echo $shipment->shipping_price; ?> Lei
        </td>
    </tr>
        
      
        
        <tr class="total">
            <td></td>
            
            <td>
               Total: {{$total}} Lei
            </td>
        </tr>
    </table>
</div>

    
    </div>

    <div class="form-group row" style="display:block; height:100px;">
        <div class=""  style="margin-right:15px;float:right">
        <button class="btn btn-primary btn-lg btn-block dld"  >Download</button>
      </div>
  </div>




<div class="col-md-12 mb-5 mb-md-0">
        
                <h2 class="h3 mb-3 text-black">Detalii livrare</h2>
                <div class="p-3 p-lg-5 border">
                 
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
                      <input type="text" disabled class="form-control" id="c_fname" name="c_fname" value="<?php echo $shipment->first_name;?>">
                    </div>
                    <div class="col-md-6">
                      <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" disabled id="c_lname" name="c_lname" value="<?php echo $shipment->last_name;?>">
                    </div>
                  </div>
        
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" disabled id="c_address" name="c_address" placeholder="Street address" value="<?php echo $shipment->address;?>">
                    </div>
                    <div class="col-md-6">
                        <label for="c_address" class="text-black">Address</label>
                        <input type="text" class="form-control"  disabled placeholder="Apartment, suite, unit etc. (optional)" value="<?php echo $shipment->address_sec;?>">
                      </div>
                  </div>
        
                
        
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="c_state_country" class="text-black">State <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" disabled id="c_state_country" name="c_state_country" value="<?php echo $shipment->state;?>">
                    </div>
                    <div class="col-md-6">
                      <label for="c_postal_zip" class="text-black"> Zip <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" disabled id="c_postal_zip" name="c_postal_zip" value="<?php echo $shipment->zip;?>">
                    </div>
                  </div>
        
                  <div class="form-group row mb-5">
                    <div class="col-md-6">
                      <label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" disabled id="c_phone" name="c_phone" placeholder="Phone Number" value="<?php echo $shipment->phone_number;?>">
                    </div>
                  </div>

                  <div class="form-group row mb-5">
                        <div class="col-md-6">
                          <label for="c_phone" class="text-black">Delivered by</label>
                          <input type="text" class="form-control" disabled id="c_deliver" name="c_deliver" placeholder="" value="<?php echo $shipment->courier;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="c_phone" class="text-black">AWB</label>
                            <input type="text" class="form-control" disabled id="c_awb" name="c_awb" placeholder="" value="<?php echo $shipment->shipment_tracking_number;?>">
                          </div>
                        
                  </div>

                

        </div>
</div>

  
</div>


<style>
    .invoice-box{
        width:100%;
        transition: all .5s ease;

    }.downloading{
        width:775px;
        transition: all .7s ease;
    }
        .table td:first-child{
            width:80%;
        }</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script>
  window.onload = function(){
        $('.dld').on('click',function(ev){
            var quality  = 10;
            var filename  = 'ThisIsYourPDFFilename.pdf';
            $('.invoice-box').addClass('downloading');
            setTimeout(function(){
		    html2canvas($('.invoice-box>table')[0], 
								{scale: 0.1,
                                onrendered: function (canvas) {
                                                canvas.getContext("2d").scale(0.6,0.6);
                                                var pdf = new jsPDF('p', 'pt', 'a4',{orientation:'landscape'});
                                                window.pdf = pdf;
                                                window.image = canvas.toDataURL('image/png',wid = canvas.width/2, hgt = canvas.height/2);
                                                pdf.addImage(window.image, 'PNG', 25, 25, 0, 0);
                                                pdf.save(filename);
                                                $('.invoice-box').removeClass('downloading');
                                }}
                        );
            },1500);
        })
  }
</script>
@endsection