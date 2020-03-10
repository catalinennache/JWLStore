@extends('layouts.base')

@section('page_content')
<script src="https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js"></script>
<input type="hidden" value="" name="order_stamp">
    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12">
            <div class=" p-1 " role="alert">
              <span style="display:block; text-align:center;font-size:32px;color:black;width:50%;border-bottom:1px dashed black; margin:0 auto;">Checkout</span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <div class="col-md-12" >

            <!--div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Coupon Code</h2>
                <div class="p-3 p-lg-5 border">
                  
                  <label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
                  <div class="input-group w-75">
                    <input type="text" class="form-control" id="c_code" placeholder="Coupon Code" aria-label="Coupon Code" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm px-4" type="button" id="button-addon2">Apply</button>
                    </div>
                  </div>

                </div>
              </div>
            </div-->
            
            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Finalizare</h2>
                <div class="p-3 p-lg-5 border" style="background:white; border:1px dashed black!important">
                  <table class="table site-block-order-table mb-5">
                    <thead>
                      <th>Product</th>
                      <th>Total</th>
                    </thead>
                    <tbody>
                      <?php $total = 0; 
                           foreach($cart as $prod_id => $sizes_pcs) {
                            $product = DB::table('Products')->where('product_id',$prod_id)->first();
                            foreach ($sizes_pcs as $size => $pcs) {
                            $size = DB::table('Sizes')->where('size_id',$size)->first()->description;
                       ?> <tr>
                        <td><a href="/shops?id=<?php echo $prod_id;?>"><?php echo $product->product_name.' '.$size;?> <strong class="mx-2">x</strong> <?php echo $pcs; ?></td>
                        <td><?php echo (($product->product_new_price?$product->product_new_price:$product->product_price)*$pcs).' Lei';?> </td>
                       </tr> <?php $total += (($product->product_new_price?$product->product_new_price:$product->product_price)*$pcs); }} ?>
                       <tr>
                        <td><?php echo $transport->name.' Transport';?></td>
                        <td><?php echo $transport->price.' Lei';?> </td>
                       </tr> 
                      <tr>
                        <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                        <td class="text-black font-weight-bold"><strong><?php echo ($total+$transport->price).' Lei'?></strong></td>
                      </tr>
                    </tbody>
                  </table>
                @if ($pm == 1)
                <div class=" mb-3 payment_option">
                  
                  <div class="show" id="collapsebank">
                  
                    <div class="form-group">
                      <div id="dropin-container">
                      </div>
                        <button class="btn btn-primary btn-lg btn-block finish-checkout" id="open-card-modal" style="margin-top:10px;" onclick="">Plateste</button>
                        <span class="processing-payment hidden msg" style="color:red;margin-top:10px;"> Procesare plata, va rugam asteptati. </span> 
                        <span class="scs-payment hidden msg" style="color:green;margin-top:10px;"> Succes plata! </span> 
                        <span class="processing-order hidden msg" style="color:red;margin-top:10px;"> Procesare comanda, va rugam asteptati. </span> 
                        <span class="scs-order hidden msg" style="color:green;margin-top:10px;"> Succes! </span> 
                     
                     

                        <script>


                           braintree.dropin.create({
                             authorization: "{{ Braintree_ClientToken::generate() }}",
                             container: '#dropin-container' 
                           
                           }, function (createErr, instance) {
                             console.log(createErr,instance);
                             window.instance = instance;
                         
                          
                           });
                       </script>
                      </div>
                  </div>
                </div>

                @else
                  <div class=" p-3 mb-3 payment_option">
                    <div class="form-group">
                      <button class="btn btn-primary btn-lg btn-block finish-checkout" id="open-ramburs-modal" >Plateste Ramburs</button>
                      <span class="processing-order hidden msg" style="color:red;margin-top:10px;"> Comanda e in procesare, va rugam asteptati. </span> 
                      <span class="scs-order hidden msg" style="color:green;margin-top:10px;"> Succes! </span> 
                   
                    </div>
                
                  </div>

                @endif
                
                
                  <!--div class="border p-3 mb-5 payment_option">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsepaypal" role="button" aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>

                    <div class="collapse" id="collapsepaypal">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                      <div class="form-group">
                          <button class="btn btn-primary btn-lg btn-block finish-checkout" id="paypal" >Continue with Paypal</button>
                          <div ></div>
                        
                        </div>
                    </div>
                    </div-->
                  </div>

                  <style>
                    .hidden{display: none;}
                    .payment_option{
                      max-width:850px;
                      margin:0 auto;
                    }
                    .payment_option button{
                      max-width: 300px;
                      margin:0 auto;
                    }
                    .msg{
                       width:100%;
                       text-align: center;
                       display: block;
                    }
                  </style>
                  

                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>

   
    <style>
      .hidden{
        display: none;
      }
    </style>
  
          

    <script async src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js" class="bootbox"></script>
    <script>
    $('.bootbox').on('load', function(){
        // alert("script loaded");
        console.log("bootbox inited");
       
          $('#open-card-modal').on('click',function(ev){
              bootbox.confirm({ 
                size: "small",
                message: "Finalizati plata cu cardul?",
                buttons: {
                  confirm: {
                      label: 'Da',
                      className: 'btn-primary'
                    },
                  cancel: {
                      label: 'Anuleaza',
                      className: ''
                    }
                },backdrop:true,
                  callback: function(answer){
                      if(answer){
                        $('.processing-payment').removeClass("hidden");
       
                        instance.requestPaymentMethod(function (err, payload) {
                          console.log(err);
                          if(err == null){
                            $('.processing-payment').addClass("hidden");
       
                            $('.scs-payment').removeClass("hidden");
                            $('.processing-order').removeClass("hidden");
                              $.get('{{ route('payment.ProcessCheckout') }}', {payload,trigger_type:"card"}, function (response) {
                                if (response.success) {
                                  console.log(response);
                                  $('.processing-order').addClass("hidden");
       
                                  $('.scs-order').removeClass("hidden");
                                     window.location.href ="/thank";
                                 // alert('Payment successfull!');

                                } else {
                                  alert('A aparut o problema, va rugam reincercati mai tarziu sau contactati magazinul');
                                }
                              }, 'json');
                          }else{
                            alert('Plata nu a fost acceptata, va rugam reincercati mai tarziu sau contactati magazinul');
                              
                          }
                            });
                      }
                   }
              })

        })

        $('#open-ramburs-modal').on('click',function(ev){
          $('.processing-order').removeClass("hidden");
          $.get('{{ route('payment.ProcessCheckout') }}', {trigger_type:"ramburs"}, function (response) {
                                if (response.success) {
                                  console.log(response);
                                  window.location.href ="/thank";
                                 // alert('Payment successfull!');
                                    $('.scs-order').removeClass("hidden");
                                } else {
                                  alert('Plata nu a fost acceptata, va rugam reincercati mai tarziu sau contactati magazinul');
                                  window.location.reload();
                                }
                              }, 'json');
                            });
        })
    //  });

    



      window.onload = function(){

        $('.payment_option').on('click',function(ev){
          $('.collapse.show').removeClass('show');
           $('.collapse.show').parent().find('.d-block').addClass('collapsed');

        })

        $('.finish-checkout').on('click',function(ev){

          var form = document.createElement('form');
          form.method = "POST";
          form.action = "/checkout";
          form.style.display = "none";
          var buffer = "";
          $('.checkout-details input').each(function(index,element){
              console.log(element.name,element.type == "checkbox"?element.checked:element.value);
              buffer += element.name+"\n";
              form.appendChild($(element).clone()[0]);
              if(index == $('.checkout-details input').length - 1){
                var pmt = document.createElement('input');
                pmt.name = "trigger_type";
                pmt.value = ev.target.id;
                form.appendChild(pmt);
                document.body.appendChild(form);
                //form.submit();
                console.log(buffer);
              }
          })

        })

      }
    </script>
    <style>
        .bootbox.modal>*{
          margin-top:150px;
        }
        .bootbox-body{
          font-size: 20px;
          color:black;
        }
      </style>

    @endsection