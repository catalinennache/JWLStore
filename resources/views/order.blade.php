@extends('layouts.base')

@section('page_content')
<div class="container">
    <div class="row">
<div class="col-md-12 p-lg-3" style="margin-top:20px;">
    <h2 class="h3 mb-3 text-black">Order #<?php echo $order->AWB;?></h2>
    <div class="p-3 p-lg-3 ">
      <table class="table site-block-order-table mb-5">
        <thead>
          <th>Ordered Products</th>
          <th>Total</th>
        </thead>
        <tbody>
          <?php 
            $total = 0;
            foreach ($ordered_items as $item) {  ?>
              
          <tr>
            <td title="Ring 414, Necklace RNG"><a href="/shops?id=<?php echo $item->product_id;?>"> <?php echo $item->product_name;?></a></td>
            <td><?php $total += $item->order_item_price; echo $item->order_item_price.' Lei';?></td>
          </tr>

            <?php }?>
         
         
          <tr>
            <td class="text-black font-weight-bold"><strong>Total</strong></td>
            <td class="text-black font-weight-bold"><strong><?php echo $total.' Lei';?></strong></td>
          </tr>
        </tbody>
      </table>
    
    </div>
  </div>




<div class="col-md-12 mb-5 mb-md-0">
        <h2 class="h3 mb-3 text-black">Billing Details</h2>
        <div class="p-3 p-lg-5 border">
         
          <div class="form-group row">
            <div class="col-md-6">
              <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
              <input type="text" disabled class="form-control" id="c_fname" name="c_fname" value="<?php echo $invoice->first_name;?>">
            </div>
            <div class="col-md-6">
              <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" disabled id="c_lname" name="c_lname" value="<?php echo $invoice->last_name;?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
              <input type="text" class="form-control" disabled id="c_address" name="c_address" placeholder="Street address" value="<?php echo $invoice->address;?>">
            </div>
          </div>

          <div class="form-group">
            <input type="text" class="form-control"  disabled placeholder="Apartment, suite, unit etc. (optional)" value="<?php echo $invoice->address_sec;?>">
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <label for="c_state_country" class="text-black">State <span class="text-danger">*</span></label>
              <input type="text" class="form-control" disabled id="c_state_country" name="c_state_country" value="<?php echo $invoice->state;?>">
            </div>
            <div class="col-md-6">
              <label for="c_postal_zip" class="text-black"> Zip <span class="text-danger">*</span></label>
              <input type="text" class="form-control" disabled id="c_postal_zip" name="c_postal_zip" value="<?php echo $invoice->zip;?>">
            </div>
          </div>

          <div class="form-group row mb-5">
            <div class="col-md-6">
              <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
              <input type="text" class="form-control" disabled id="c_email_address" name="c_email_address" value="<?php echo $invoice->email;?>">
            </div>
            <div class="col-md-6">
              <label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>
              <input type="text" class="form-control" disabled id="c_phone" name="c_phone" placeholder="Phone Number" value="<?php echo $invoice->phone_number;?>">
            </div>
          </div>

          <div class="col-md-12 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black">Shipping Details</h2>
                <div class="p-3 p-lg-5">
                 
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

                  <div class="form-group row">
                      <div class="col-md-3">
                      <button class="btn btn-primary btn-lg btn-block"  onclick="window.location='/'">Cancel Order</button>
                    </div>

        </div>
</div>

    </div>
</div>


<style>
        .table td:first-child{
            width:80%;
        }</style>

@endsection