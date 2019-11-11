@extends('layouts.base')
@section('page_content')

    <div class="site-blocks-cover" data-aos="fade" style="background:white;">
      <div class="container">
        <div class="row">
          <div class="col-md-6 ml-auto order-md-2 align-self-start">
            <div class="site-block-cover-content">
            <h2 class="sub-title">#New Summer Collection 2019</h2>
            <h1>Arrivals Sales</h1>
            <p><a href="#" class="btn btn-black rounded-0">Shop Now</a></p>
            </div>
          </div>
          <div class="col-md-6 order-1 align-self-end">
            <img src="images/asdpor.jpeg" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" style="width:100%;">
      <div class="container" style="max-width:none!important;width:85%;">
        <div class="row">
          <div class="title-section mb-5 col-12">
            <h2 class="text-uppercase">Collections</h2>
          </div>
        </div>
        <div class="row align-items-stretch">
          <div class="col-lg-4 grid-section">
            <div class="product-item sm-height full-height bg-gray">
              <a href="#" class="product-category">Women <span>25 items</span></a>
              <img src="images/square.png" alt="Image" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-4 grid-section">
            <div class="product-item sm-height bg-gray ">
              <a href="#" class="product-category">Men <span>25 items</span></a>
              <img src="images/rectangle_med.jpg" alt="Image" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-4 grid-section">
           
            <div class="product-item sm-height bg-gray ">
              <a href="#" class="product-category">Men <span>25 items</span></a>
              <img src="images/rectangle_med.jpg" alt="Image" class="img-fluid">
            </div>
            <div class="product-item sm-height bg-gray ">
              <a href="#" class="product-category">Men <span>25 items</span></a>
              <img src="images/rectangle_med.jpg" alt="Image" class="img-fluid">
            </div>
          </div>
        
        </div>

        <div class="row align-items-stretch">
          <div class="col-lg-4 grid-section">
            <div class="product-item sm-height full-height bg-gray">
              <a href="#" class="product-category">Women <span>25 items</span></a>
              <img src="images/bow_ring.jpg" alt="Image" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-3 grid-section">
            <div class="product-item sm-height bg-gray mb-4">
              <a href="#" class="product-category">Men <span>25 items</span></a>
              <img src="images/ring.jpeg" alt="Image" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-5 grid-section">
            <div class="product-item sm-height bg-gray mb-4">
              <a href="#" class="product-category">Men <span>25 items</span></a>
              <img src="images/rectangle_high_edited.jpg" alt="Image" class="img-fluid">
            </div>
          </div>
        </div>

        <div class="row align-items-stretch">
          <div class="col-lg-12 grid-section">
            <div class="product-item sm-height full-height bg-gray">
              <a href="#" class="product-category">Women <span>25 items</span></a>
              <img src="images/bow_ring.jpg" alt="Image" class="img-fluid">
            </div>
          </div>
         
        </div>
      </div>
    </div>
<style>
  
  .site-section{
    background: #f9f9f9;
  }
  .grid-section{
    margin-top:15px;
  } div.product-item{
    padding:0!important;
    background: white!important;
    border:1px solid transparent;
    box-shadow: 1px 5px 20px #e2e2e2;
    transition: .3s ease-out;
  }

  div.product-item:first-of-type{
    margin-bottom: 15px;
  }
  div.product-item:hover>img{
   
    transition: 0.3s ease-out;
  }


  div.product-item:after {
    content:'\A';
    position:absolute;
    width:100%; height:100%;
    top:0; left:0;
    background:rgba(0,0,0,0.6);
    opacity:0;
    transition: all 0.3s;
    -webkit-transition: all 0.3s;
}
div.product-item:hover{
  box-shadow:  1px 5px 20px #a2a1a1;
  transform: scale(1.016);
}
div.product-item:hover:after {
    /*opacity:1;*/
    
}
div.product-item>img{
  left: unset; 
   top: unset;
     -webkit-transform: none; 
    -ms-transform: none;
     transform: none; 
    -o-object-fit: cover;
    object-fit: cover;
     max-width: 100%; 
    position: absolute;
    /*height: 100%;*/
    transition: .3s ease-out;
    display: block;
    margin: 0 auto;
    position: relative;
}

.site-section .popular{
  max-width: 85%;
}

.site-section  .popular .item-entry{
  padding: 0 15px;
  max-width: 32.33333%;
    margin-right: 1%;
}
.site-section   .item-entry img{
  transition: .3s ease-out;/* 
  left:unset;
  top: unset;
  position: relative;
  display: block;
  margin: 0 auto;
  transform: unset!important;
  object-fit: unset;*/
}
.site-section   .item-entry{
  box-shadow: 1px 5px 20px #e2e2e2;
  transition: .3s ease-out;
}
 .item-entry:hover{
  box-shadow: 1px 5px 20px #a2a1a1!important;
  
}


.site-section .recent .item-entry{
  padding: 0 15px;
}
.site-section  .recent .item-entry img{
  transition: .3s ease-out;
}
.site-section  .recent .item-entry{
  box-shadow: 1px 5px 20px #e2e2e2;
  transition: .3s ease-out;
}
.site-section .item-entry:hover img{
  /*box-shadow: 1px 5px 20px #a2a1a1;
  transform:scale(1.1);
  left: 2.5%;*/
  transform: translateX(-50%) scale(1.05)!important;
  
  
}
/*div.product-item>img{
  transition: .5s ease-out;
  border:1px solid transparent;
       left: unset; 
    top: unset; 
     -webkit-transform: unset; 
    -ms-transform: none;
     transform: unset;
  object-fit: scale-down;

    margin: 0 auto;
    max-height: 625px;
    max-width: 100%;
    position: relative;
    height: 100%;
    display: block;
}*/
  
  </style>

    
    <div class="site-section">
      <div class="container popular">
        <div class="row">
          <div class="title-section mb-5 col-12">
            <h2 class="text-uppercase">Popular Products</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="#" class="product-item md-height bg-gray d-block">
              <img src="images/prod_2.png" alt="Image" class="img-fluid">
            </a>
            <h2 class="item-title"><a href="#">Gray Shoe</a></h2>
            <strong class="item-price">$20.00</strong>
          </div>
          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="#" class="product-item md-height bg-gray d-block">
              <img src="images/prod_3.png" alt="Image" class="img-fluid">
            </a>
            <h2 class="item-title"><a href="#">Blue Shoe High Heels</a></h2>
            <strong class="item-price"><del>$46.00</del> $28.00</strong>
          </div>

          <div class="col-lg-4 col-md-6 item-entry mb-4">
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
          <div class="col-lg-4 col-md-6 item-entry mb-4">
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

          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="#" class="product-item md-height bg-gray d-block">
              <img src="images/model_1.png" alt="Image" class="img-fluid">
            </a>
            <h2 class="item-title"><a href="#">Smooth Cloth</a></h2>
            <strong class="item-price"><del>$46.00</del> $28.00</strong>
          </div>
          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="#" class="product-item md-height bg-gray d-block">
              <img src="images/model_7.png" alt="Image" class="img-fluid">
            </a>
            <h2 class="item-title"><a href="#">Yellow Jacket</a></h2>
            <strong class="item-price">$58.00</strong>
          </div>

        </div>
      </div>
    </div>

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
                  <a href="#" class="product-item md-height bg-white d-block">
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

    @endsection

