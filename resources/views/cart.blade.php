@extends('layouts.base')

@section('page_content')

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
         <?php $total =0 ; try{$cnt =  count($cart);}catch(Exception $e){$cnt = 0;} if($cnt> 0){ ?>
           <form class="col-md-12 cart" method="post">
            <div class="site-blocks-table">
             <div class="table-wrapper desktop-only"> <table class="table table-bordered ">
                <thead>
                  <tr>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <?php  foreach ($cart as $prod_id => $size_pcs) {
                   $product = DB::table('Products')->where('product_id',$prod_id)->first();
                
                  foreach ($size_pcs as $size => $pcs) {
                    $size = DB::table('Sizes')->where('size_id',$size)->first();
                   
                    ?>
                  <tr id="<?php echo $product->product_id;?>" size="<?php echo $size->size_id;?>">
                   
                    <td class="product-name">
                    <img src="images/products/product_{{$product->product_id}}/small/<?php try{echo $product->product_image;}catch(Exception $e){} ?>" alt="Image" class="" style="max-width:300px;">
                      <h2 class="h5 text-black" style="margin-top:8%;"><a href="/shops?id=<?php echo $prod_id;?>"><?php echo $product->product_name.' '.$size->description; ?></a></h2>
                    </td>
                    <td><?php echo $product->product_price.' Lei'; ?></td>
                    <td>
                      <div class="input-group mb-3" style="max-width: 120px; margin:0 auto;">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center pcs" value="<?php echo $pcs;?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                        </div>
                      </div>

                    </td>
                    <td class="prod-total"><?php echo $pcs*$product->product_price.' Lei'; $total += $pcs*$product->product_price; ?></td>
                    <td><a  class="btn btn-primary height-auto btn-sm removeFromCart" style="color:white;">X</a></td>
                  </tr>
                <?php }} ?>
                  
                </tbody>
              </table>
            </div>
              <div class="table-wrapper mobile-only">
              <table class="table table-bordered " style="border:none!important;">
                <thead>
                  <tr>
                    <th class="product-name">Produse</th>
                  </tr>
                </thead>
                <tbody>
                  <?php   foreach ($cart as $prod_id => $size_pcs) {
                   $product = DB::table('Products')->where('product_id',$prod_id)->first(); 
               
                    foreach ($size_pcs as $size => $pcs) {  
                     $size = DB::table('Sizes')->where('size_id',$size)->first();
                   
                      ?>
                       <tr id="<?php echo $product->product_id;?>" size="<?php echo $size->size_id;?>">
                   
                    <td class="product-name">
                      <div>
                      <img src="images/products/product_{{$product->product_id}}/small/<?php try{echo $product->product_image;}catch(Exception $e){} ?>" alt="Image" class="" style="max-width:300px;">
                      <h2 class="h5 text-black" style="margin-top:8%;"><a href="/shops?id=<?php echo $prod_id;?>"><?php echo $product->product_name.' '.$size->description; ?></a> - <?php echo $product->product_price.' Lei'; ?> / buc</h2>
                      
                     
                    <div>
                      <div class="input-group mb-3" style="max-width: 120px; margin:0 auto;">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center pcs" value="<?php echo $pcs;?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                        </div>
                      </div>

                    </div>
                    <div class="prod-total text-black"><?php echo $pcs*$product->product_price.' Lei'; ?></div>
                    <div><a  class="btn btn-primary height-auto btn-sm removeFromCart" style="color:white;">Elimina din cos</a></div>
                 
                    
                    </div>
                    </td>
                  </tr>
                <?php }} ?>
                </tbody>
              </table> 
            </div>
            </div>
          </form>
        <?php } else { ?>
           <style> .container .row{margin:unset;} </style>
            <h2> The cart is empty for now, shop on.. </h2>
        <?php } ?>    
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <?php if($cnt > 0) {?>
                <div class="col-md-6 mb-3 mb-md-0">
                 <button class="btn btn-primary btn-sm btn-block update-cart">Update Cart</button>
                </div>
              <?php } ?>
              <div class="col-md-6 no-padding-left-desktop" style="">
                <button class="btn btn-outline-primary btn-sm btn-block" onclick="window.location.href = '/shop'">Continue Shopping</button>
              </div>
            </div>
            <!--div class="row">
              <div class="col-md-12">
                <label class="text-black h4" for="coupon">Coupon</label>
                <p>Enter your coupon code if you have one.</p>
              </div>
              <div class="col-md-8 mb-3 mb-md-0">
                <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary btn-sm px-4">Apply Coupon</button>
              </div>
            </div-->
          </div>
          <div class="col-md-6">
            <div class="row justify-content-end">
            <?php if($cnt > 0){ ?>
               <div class="col-md-7">
                <!--div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div-->
                <!--div class="row mb-3">
                  <div class="col-md-6">
                    <span class="text-black">Subtotal</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">$230.00</strong>
                  </div>
                </div-->
                <div class="row mb-5 prev-checkout">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div class="col-md-6 text-right prev-checkout">
                    <strong class="text-black cart-total"><?php echo $total.' Lei'; ?></strong>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg btn-block" onclick="window.location='/checkout'">Proceed To Checkout</button>
                  </div>
                </div>
            </div> <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <style>
      .desktop-only{
          display:block;
        }
        .mobile-only{
          display: none;
        }

        .table-wrapper>table{
        
        position:relative;
        border-collapse: collapse;
        text-align: center;
      }
      @media screen and (max-width: 767px){
        .prev-checkout{
          display: block;
          text-align: left!important;
        }
      }
      @media screen and (max-width: 999px){
        .desktop-only{
          display:none;
        }
        .mobile-only{
          display: block;
        }
        .table-wrapper{
          padding: 0 25px;
        }
        
      }
      @media screen and (max-width: 420px){
        .table-wrapper{
          padding:0;
        }
        .cart{
          padding:5vw;
        }
      }
      @media screen and (max-width: 381px){
        .cart{
          padding:1px;
        }
      }
    </style>
    <script>
        window.onload = function(){

        $('.removeFromCart').on('click',function(ev){
          var active_table =$(ev.target).closest('tbody');
          $.ajax({
            type:"POST",
            url:"/api/removeFromCart",
            data:{id:$(ev.target).closest('tr').attr('id'),
                  size:$(ev.target).closest('tr').attr('size'),
                  _token:"{{ csrf_token() }}"
                  },
            success:function(data){
              if(data.scs){
                if($(ev.target).closest('tbody').find('tr').length <= 2)
                  window.location.reload();
                  else{
                    $(ev.target).closest('tr').remove();
                    var total = 0.00;
                    window.active_table = active_table;
                    $(active_table).find('.prod-total').each(function(index,element){
                      total += parseFloat(element.innerHTML.split(' ')[0]);
                      if(index ==  $(active_table).find('.prod-total').length -1){
                        total = Math.round(total*100)/100;
                        $('.cart-total').html(total);
                      }
                    })
                   
                  }
                
              }
            },error:function(data){
      
            }
          })
        });
        
        $('.update-cart').on('click',function(ev){
          var data = [];
          var active_table = $('.cart .table-wrapper:first').is(':visible')?$('.cart .table-wrapper:first tbody'):$('.cart .table-wrapper:last tbody');
          active_table.find('tr').each(function(index,element){
            element = $(element);
            var id = element.attr('id');
            var size = element.attr('size');
            var pcs = element.find('.pcs').val();
            data.push({
              id:id,
              size:size,
              pcs:pcs
            })
          });
          $.ajax({
            type:"POST",
            url:"/api/updateCart",
            data:{data:data,
                  _token:"{{ csrf_token() }}"
                  },
            success:function(data){
              window.location.reload();
            },error:function(data){
              window.location.reload();
            }

        }) });
        
        $('.pcs').on('change',function(data){
          console.log(data);
            if(this.value == 0){
              $(this).val(1);
            }
        })
    }
    </script>
@endsection

