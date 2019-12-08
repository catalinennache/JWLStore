@extends('layouts.base')
@section('page_content')

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="item-entry">
              <a href="" class="product-item md-height bg-white d-block">
                <img src="images/products/<?php try{echo $prod->product_image;}catch(Exception $e){} ?>" alt="Image" class="img-fluid">
                
              </a>
              
            </div>

          </div>
          <div class="col-md-6">
            <h2 class="text-black"><?php echo $prod->product_name; ?></h2>
            <p><?php echo $prod->product_description?></p>
            <p><?php print_r(session('cart_products'));?>
            <p><strong class="text-primary h4"><strong class="item-price">
              <?php if($prod->product_new_price != 0){ ?> <del> <?php echo $prod->product_price; ?></del> <?php } ?>
                   <?php
                   if($prod->product_new_price != 0){
                      echo  $prod->product_new_price .' Lei';
                   }else {
                      echo $prod->product_price.' Lei';
                    }
                  ?>
                  </strong></strong></p>
            <div class="mb-1 d-inline-block">
             
              <?php $cnt = count($sizes); foreach ($sizes as $size) { ?>
                <label for="option-<?php echo $size->size; ?>" class="d-inline-block <?php echo 'mr-'.$cnt.' mb-'.$cnt;?> ">
                  <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input <?php if($size->Quantity_AV == 0) echo 'title="Aceasta marime nu se afla in stock."'?> type="radio" <?php if($size->Quantity_AV == 0) echo 'disabled'?> id="option-<?php echo $size->size; ?>" value="<?php echo $size->size; ?>" name="shop-sizes"></span> <span class="d-inline-block text-black"><?php echo $size->description; ?> </span>
                </label>

              <?php } ?>
                
            </div>
            <div class="mb-5">
              <div class="input-group mb-3" style="max-width: 120px;">
              <div class="input-group-prepend">
                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
              </div>
              <input type="text" class="form-control text-center pcs" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
              <div class="input-group-append">
                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
              </div>
            </div>

            </div>
            <div><a  class="disabled buy-now btn btn-sm height-auto px-4 py-3 btn-primary" style="float:left;color:white!important;">Add To Cart</a>
              <div class="col-md-1" style="margin-top:5px;display:inline-flex;">
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
    </div>

    <!--div class="site-section block-3 site-blocks-2">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Featured Products</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 block-3">
            <div class="nonloop-block-3 owl-carousel">
              <div class="item">
                <div class="item-entry">
                  <a href="#" class="product-item md-height bg-gray d-block">
                    <img src="images/model_1.png" alt="Image" class="img-fluid">
                  </a>
                  <h2 class="item-title"><a href="#">Smooth Cloth</a></h2>
                  <strong class="item-price"><del>$46.00</del> $28.00</strong>
                  <div class="star-rating">
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="item-entry">
                  <a href="#" class="product-item md-height bg-gray d-block">
                    <img src="images/prod_3.png" alt="Image" class="img-fluid">
                  </a>
                  <h2 class="item-title"><a href="#">Blue Shoe High Heels</a></h2>
                  <strong class="item-price"><del>$46.00</del> $28.00</strong>

                  <div class="star-rating">
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="item-entry">
                  <a href="#" class="product-item md-height bg-gray d-block">
                    <img src="images/model_5.png" alt="Image" class="img-fluid">
                  </a>
                  <h2 class="item-title"><a href="#">Denim Jacket</a></h2>
                  <strong class="item-price"><del>$46.00</del> $28.00</strong>

                  <div class="star-rating">
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                  </div>

                </div>
              </div>
              <div class="item">
                <div class="item-entry">
                  <a href="#" class="product-item md-height bg-gray d-block">
                    <img src="images/prod_1.png" alt="Image" class="img-fluid">
                  </a>
                  <h2 class="item-title"><a href="#">Leather Green Bag</a></h2>
                  <strong class="item-price"><del>$46.00</del> $28.00</strong>
                  <div class="star-rating">
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="item-entry">
                  <a href="#" class="product-item md-height bg-gray d-block">
                    <img src="images/model_7.png" alt="Image" class="img-fluid">
                  </a>
                  <h2 class="item-title"><a href="#">Yellow Jacket</a></h2>
                  <strong class="item-price">$58.00</strong>
                  <div class="star-rating">
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div-->

    <div class="site-section">
      <div class="container recent">
        <div class="row">
          <div class="title-section text-center mb-5 col-12">
            <h2 class="text-uppercase">Recently Viewed</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 block-3">
            <div class="nonloop-block-3 owl-carousel">
              <?php foreach ($products as $product) { ?>
              <div class="item">
                <div class="item-entry" style="background:white;">
                  <a href="/shops?id=<?php echo $product->product_id;?>" class="product-item md-height bg-white d-block">
                    <img src="images/products/<?php try{echo $product->product_image;}catch(Exception $e){} ?>" alt="Image" class="img-fluid">
                  </a>
                  <h2 class="item-title"><a href="/shops?pd=<?php echo $product->product_id; ?>"> <?php echo $product->product_name; ?></a></h2>
                  <strong class="item-price">
                  <?php if($product->product_new_price != 0){ ?> <del> <?php echo $product->product_price; ?></del> <?php } ?>
                       <?php
                       if($product->product_new_price != 0){
                          echo  $product->product_new_price .' Lei';
                       }else {
                          echo $product->product_price.' Lei';
                        }
                      ?>
                      </strong>
                  <div class="star-rating">
                    <style> .icon-star2{opacity:0!important;}</style>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                    <span class="icon-star2 text-warning"></span>
                  </div>
                </div>
              </div>
            <?php } ?>
            
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      window.prodid = "<?php echo $prod->product_id;?>";
      window.onload = function(){
        $('input[name=shop-sizes]').on('click',function(ev){
          if($('input[name=shop-sizes]:checked').val()){
            $('.buy-now').removeClass('disabled');
          }
        });

        $('.buy-now').on('click',function(ev){
          if(!$('input[name=shop-sizes]:checked').val())
              return;
          $('.loader').removeClass('hidden');
           $.ajax({
             type:"POST",
             url:"/api/addtocart",
             data:{id:window.prodid,
                   pcs:$('.pcs').val(),
                   size:$('input[name=shop-sizes]:checked').val(),
                  _token: "{{ csrf_token() }}"
                  },
             success:function(data){
              if(data.scs){
                $('.loader').addClass('done');
                setTimeout(function(){
                  $('.loader').addClass('hidden');
                  setTimeout(function(){ $('.loader').removeClass('done'); },700);
                },4500)
              }else
                    $('.loader').addClass('hidden');
              
             },
             error:function(data){

             }
           })
        })
      }
      </script>
      <style>
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
