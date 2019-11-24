@extends('layouts.base_nofooter')

@section('page_content')

<div class="site-section">
        <div class="container">
         
          <div class="row">
            <div class="col-md-12 mb-5 mb-md-0">
              <h2 class="h3 mb-3 text-black">Profile Details</h2>
              <div class="p-3 p-lg-5 border frm">
                  <div class="form-group row">
                      <div class="col-md-12">
                        <label for="c_address" class="text-black">NickName <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_nickname" name="c_nickname" placeholder="The name shown on site." value="<?php echo Auth::user()->name;?>">
                      </div>
                    </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_fname" name="c_fname" value="<?php echo Auth::user()->first_name;?>">
                  </div>
                  <div class="col-md-6">
                    <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_lname" name="c_lname" value="<?php echo Auth::user()->last_name;?>">
                  </div>
                </div>
  
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address" value="<?php echo Auth::user()->address;?>">
                  </div>
                  <div class="col-md-6">
                      <label for="c_address_sec" class="text-black">Address</label>
                      <input type="text" class="form-control"  id="c_address_sec" name="c_address_sec" placeholder="Apartment, suite, unit etc. (optional)" value="<?php echo Auth::user()->address_sec;?>">
                  </div>
                </div>
  
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="c_state_country" class="text-black">State<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_state_country" name="c_state_country" value="<?php echo Auth::user()->state;?>">
                  </div>
                  <div class="col-md-6">
                    <label for="c_postal_zip" class="text-black"> Zip <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip" value="<?php echo Auth::user()->zip;?>">
                  </div>
                </div>
  
                <div class="form-group row mb-5">
                  <div class="col-md-6">
                    <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_email_address" disabled name="c_email_address" value="<?php echo Auth::user()->email;?>">
                  </div>
                  <div class="col-md-6">
                    <label for="c_phone" class="text-black">Phone</label>
                    <input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Phone Number" value="<?php echo Auth::user()->phone_number;?>">
                  </div>
                </div>
  
                <div class="form-group row">
                  <div class="col-md-3">
                    <button class="btn btn-primary btn-lg btn-block save-profile" type="submit" onclick="">Save</button>
                  </div>
                  <div class="col-md-1">
                      <div class="loader small hidden" style="margin-top:6px;">
                          <span class="checkmark">
                              <div class="checkmark_stem"></div>
                              <div class="checkmark_kick"></div>
                          </span>   
                      </div> 
                  </div>
                 
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 p-lg-3" style="margin-top:20px;">
                    <h2 class="h3 mb-3 text-black">Your Orders</h2>
                    <div class="p-3 p-lg-3 ">
                      <table class="table site-block-order-table mb-5">
                        <thead>
                          <th>Delivered Orders</th>
                          <th>Total</th>
                        </thead>
                        <tbody>
                          <?php 
                            $delivered_total = 0;
                            foreach ($delivered_orders as $delivered) {  ?>
                         
                          <tr>
                            <td title="Ring 414, Necklace RNG"><a href="/order?id=<?php echo $delivered->order_id;?>"> Order #<?php echo $delivered->AWB;?></a></td>
                            <td><?php $delivered_total += $delivered->total; echo $delivered->total.' Lei';?></td>
                          </tr>

                        <?php }?>
                         
                          <tr>
                            <td class="text-black font-weight-bold"><strong>Orders Total</strong></td>
                            <td class="text-black font-weight-bold"><strong><?php echo $delivered_total.' Lei'?></strong></td>
                          </tr>
                        </tbody>
                      </table>
                      <table class="table site-block-order-table mb-5">
                            <thead>
                              <th>Active Orders</th>
                              <th>Total</th>
                            </thead>
                            <tbody>
                                <?php  $active_total = 0;
                                  foreach ($active_orders as $active) {  ?>
                         
                                  <tr>
                                    <td title="Ring 414, Necklace RNG"><a href="/order?id=<?php echo $active->AWB;?>"> Order #<?php echo $active->AWB;?></a></td>
                                    <td><?php $active_total += $active->total; echo $active->total.' Lei';?></td>
                                  </tr>
        
                                <?php }?>
                             
                              
                              <tr>
                                <td class="text-black font-weight-bold"><strong>Orders Total</strong></td>
                                <td class="text-black font-weight-bold"><strong><?php echo $active_total.' Lei'?></strong></td>
                              </tr>
                            </tbody>
                          </table>
                    
                    </div>
                  </div>
          </div>
<script>
  window.onload = function(){
  $('.save-profile').on('click',function(ev){
    $('.loader').removeClass('hidden');
    var data = {};
    $('.frm input').each(function(index,element){
      data[element.name]= $(element).val();
    });
    data._token= "{{ csrf_token() }}";
    $.ajax({
      url:'/api/saveProfile',
      type:'POST',
      data:data,
      success:function(response){
        if(response.scs){
          $('.loader').addClass('done');
          setTimeout(function(){
            $('.loader').addClass('hidden');
            setTimeout(function(){ $('.loader').removeClass('done'); },700);
          },4500)
        }else
          $('.loader').addClass('hidden');
      }
    })
  });}
  </script>


<style>
.table td:first-child{
    width:80%;
}
.loader.small{
  width:30px;
  height: 30px;
  border:5px solid #f3f3f3;
  border-top: 5px solid black;
}

.checkmark {
    transition: .5s linear;
    opacity: 0;
    display:inline-block;
    width: 22px;
    height:22px;
    -ms-transform: rotate(45deg); /* IE 9 */
    -webkit-transform: rotate(45deg); /* Chrome, Safari, Opera */
    transform: rotate(45deg);
    margin-top:-1px;
    margin-left: -1px;
}

.checkmark_stem {
    position: absolute;
    width:3px;
    height:9px;
    background-color:#ccc;
    left:11px;
    top:6px;
}

.checkmark_kick {
    position: absolute;
    width:3px;
    height:3px;
    background-color:#ccc;
    left:8px;
    top:12px;
}

.done.loader{
  border-color: limegreen!important;
  animation: none!important;
  -webkit-animation: none!important;
}
.done.loader .checkmark{
  opacity: 1;
}
.done.loader .checkmark > *{
  background-color: limegreen;
}
.hidden{
  display: none;
}
</style>

@endsection