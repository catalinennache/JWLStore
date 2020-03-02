@extends('layouts.base')
@section('page_content')

    <div class="site-section">
      <div class="container">
        <div class="row" style="margin-top:25px;">
          <div class="col-md-6">
            <div class="item-entry">
            <a class="product-item md-height bg-white d-block" href="images/products/product_{{$prod->product_id}}/<?php try{echo $prod->product_image;}catch(Exception $e){} ?>" data-lightbox="example-1">
            <img src="images/products/product_{{$prod->product_id}}/small/<?php try{echo $prod->product_image;}catch(Exception $e){} ?>" alt="Image" class="img-fluid">
                
              </a>
             
            </div>
            <div class="mini-gallery"> 
              @if ($prod->product_image2)
              <a class="md-height bg-white " href="images/products/product_{{$prod->product_id}}/<?php try{echo $prod->product_image2;}catch(Exception $e){} ?>" data-lightbox="example-1">
                <img src="images/products/product_{{$prod->product_id}}/small/<?php try{echo $prod->product_image2;}catch(Exception $e){} ?>" alt="Image" class="img-fluid">
                  
                </a>   
                @endif
                @if ($prod->product_image3)
              <a class="md-height bg-white " href="images/products/product_{{$prod->product_id}}/<?php try{echo $prod->product_image3;}catch(Exception $e){} ?>" data-lightbox="example-1">
                <img src="images/products/product_{{$prod->product_id}}/small/<?php try{echo $prod->product_image3;}catch(Exception $e){} ?>" alt="Image" class="img-fluid">
                  
                </a>   
                @endif
                @if ($prod->product_image4)
              <a class="md-height bg-white " href="images/products/product_{{$prod->product_id}}/<?php try{echo $prod->product_image4;}catch(Exception $e){} ?>" data-lightbox="example-1">
                <img src="images/products/product_{{$prod->product_id}}/small/<?php try{echo $prod->product_image4;}catch(Exception $e){} ?>" alt="Image" class="img-fluid">
                  
                </a>   
                @endif
                @if ($prod->product_image5)
              <a class="md-height bg-white " href="images/products/product_{{$prod->product_id}}/<?php try{echo $prod->product_image5;}catch(Exception $e){} ?>" data-lightbox="example-1">
                <img src="images/products/product_{{$prod->product_id}}/small/<?php try{echo $prod->product_image5;}catch(Exception $e){} ?>" alt="Image" class="img-fluid">
                  
                </a>   
                @endif
                
            </div>
           
          </div>
          <div class="col-md-6 mt-mobile-25"  >
            <h2 class="text-black"><?php echo $prod->product_name; ?></h2>
          <a href="/shop?cats={{$cat->product_type_code}}">{{$cat->product_type_category}}</a>
            <p >{{$prod->product_description}}</p>
            
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
            <h6 class="text-black">Marimi disponibile:</h6>      
            <div class="mb-1 d-inline-block">
             
              <?php $cnt = count($sizes); foreach ($sizes as $size) { ?>
              <label  <?php if($size->Quantity_AV == 0) echo 'disabled'?> for="option-<?php echo $size->size_id; ?>" class="d-inline-block <?php echo 'mr-'.$cnt.' mb-'.$cnt;?> ">
                  <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input max_val="{{$size->Quantity_AV}}" <?php if($size->Quantity_AV == 0) echo 'title="Aceasta marime nu se afla in stock."'?> type="radio" <?php if($size->Quantity_AV == 0) echo 'disabled'?> id="option-<?php echo $size->size_id; ?>" value="<?php echo $size->size_id; ?>" name="shop-sizes"></span> <span class="d-inline-block text-black"><?php echo $size->description; ?> </span>
                </label>

              <?php } ?>
                
            </div>
            <div class="q-b-wrapper">
            <div class="mb-5 ">
              <div class="input-group mb-3 hdn" style="max-width: 120px;">
              <div class="input-group-prepend">
                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
              </div>
              <input type="text" class="form-control text-center pcs " value="1" readonly placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" style="background:white;">
              <div class="input-group-append">
                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
              </div>
            </div>

            </div>
            <div><a  class="disabled buy-now btn btn-sm height-auto px-4 py-3 btn-primary float-right-mobile" style="float:left;color:white!important;">Add To Cart</a>
              <div class="col-md-1 float-left-mobile" style="margin-top:5px;width:auto;display:inline-flex;">
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
    </div>

    <!--
       <div>
      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/></a>
      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-4.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-4.jpg" alt="" /></a>
      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-5.jpg" data-lightbox="example-set" data-title="The next image in the set is preloaded as you're viewing."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-5.jpg" alt="" /></a>
      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-6.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-6.jpg" alt="" /></a>
    </div>
      
      div class="site-section block-3 site-blocks-2">
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
      @if(count($rws)>0)
      <div class="container recent">
        <div class="row">
          <div class="title-section text-center mb-5 col-12">
            <h2 class="text-uppercase">Recently Viewed</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 block-3">
            <div class="nonloop-block-3 owl-carousel">
              <?php foreach ($rws as $product) { ?>
              <div class="item">
                <div class="item-entry" style="background:white;">
                  <a href="/shops?id=<?php echo $product->product_id;?>" class="product-item md-height bg-white d-block">
                  <img src="images/products/product_{{$product->product_id}}/<?php try{echo $product->product_image;}catch(Exception $e){} ?>" alt="Image" class="img-fluid">
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
      @endif
    </div>

    <style>
      .pcs{
        transition: .5s ease;
      }
      .hdn{
        opacity: 0!important;
      }
      </style>
    <script>
      window.prodid = "<?php echo $prod->product_id;?>";
      window.jqLoaded.subscribe(function(ev){
        $('input[name=shop-sizes]').on('change',function(){
           $('.pcs').val(1);
           if($('.pcs').closest(".hdn").hasClass("hdn"))
                $('.pcs').closest(".hdn").removeClass("hdn");
        })
      });
      window.onload = function(){

       
         
        $('.pcs').on('change',function(data){
         // console.log(data);
          if($('input[name=shop-sizes]:checked').val() !== undefined){
           
            if(this.value == 0){
              $(this).val(1);
            }

            if(this.value > $('input[name=shop-sizes]:checked').attr("max_val"))
              $(this).val(this.value-1);

          }
        })


        $('input[name=shop-sizes]').closest('label').on('click',function(ev){
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

        var lightbx = document.createElement('script');
        lightbx.src="/js/lightbox.min.js";
        document.body.appendChild(lightbx);
        lightbx.onload = function(){ lightbox.option({alwaysShowNavOnTouchDevices:true})}
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
           label[disabled]{ 
            display: none!important;
          }

          .lb-nav>a{
            opacity:1!important;
          }
         
              .mini-gallery{
                display: inline-flex;

              } .mini-gallery>a{
                margin:0 10px;
                transition: .3s ease-out;
                max-width: 50%;
              }
              .mini-gallery>a:hover{
                box-shadow: 0px 0px 20px #D2D2D2;
               
              }

          

           @media screen and (max-width:767px){
             .float-left-mobile{
               float:left!important;
             }
             .float-right-mobile{
               float:right!important;
             }

             .q-b-wrapper>div:first-child{
              float: left;
           }  

           .q-b-wrapper>div:last-child{
             float: right;
           }
           .mt-mobile-25{
            margin-top:25px;
           }
           }
            </style>
@endsection
