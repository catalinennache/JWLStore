    

<?php $__env->startSection('page_content'); ?>
    <!--div class="site-blocks-cover inner-page" data-aos="fade">
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
            <img src="/images/model_4.png" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>
    </div-->



    <div class="site-section" style="width:100%;">
      <div class="container popular" style="max-width:none!important;width:85%;margin-top:100px;">
    

        <div class="row mb-5">
          <div class="col-md-9 order-2 filtered" style="margin-top:-10px;">

            <div class="row align">
              <div class="col-md-12 mb-5">
                <div class="d-flex">
                  <div class="dropdown mr-1 ml-md-auto">
                    <button type="button" class="btn btn-white btn-sm dropdown-toggle px-4" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Latest
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                      <a class="dropdown-item" href="#">Men</a>
                      <a class="dropdown-item" href="#">Women</a>
                      <a class="dropdown-item" href="#">Children</a>
                    </div>
                  </div>
                  <div class="btn-group">
                    <button type="button" class="btn btn-white btn-sm dropdown-toggle px-4" id="dropdownMenuReference" data-toggle="dropdown">Reference</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                      <a class="dropdown-item" href="#">Relevance</a>
                      <a class="dropdown-item" href="#">Name, A to Z</a>
                      <a class="dropdown-item" href="#">Name, Z to A</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Price, low to high</a>
                      <a class="dropdown-item" href="#">Price, high to low</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" style="display:block">
            
              <?php
                foreach ($products as $prod) {  ?>
                
              <div class="col-lg-4 col-md-6 item-entry mb-4 bg-white" style="display:inline-block;padding-bottom:27px;">
                <a href="/shops?id=<?php echo e($prod->product_id); ?>" class="product-item md-height  d-block">
                <img src="images/products/product_<?php echo e($prod->product_id); ?>/small/<?php echo e($prod->product_image); ?>" alt="Image" class="img-fluid">
                </a>
                <h2 class="item-title"><a href="/shops?id=<?php echo e($prod->product_id); ?>"><?php echo e($prod->product_name); ?></a></h2>
                <?php if($prod->product_new_price): ?>
                 <strong class="item-price"><del><?php echo e($prod->product_price.' Lei  '); ?></del><?php echo e($prod->product_new_price.' Lei'); ?></strong>
                <?php else: ?>
                <strong class="item-price"><?php echo e($prod->product_price.' Lei'); ?></strong>
                <?php endif; ?>
              </div>

              <?php } ?>
              
    
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                  <ul>
                    <?php if($active_tab > 0): ?>  <li><a href="#">&lt;</a></li> <?php endif; ?>
                    <?php  
                          for($i = 0; $i<$pages; $i++){
                    ?>
                    <?php if($i == $active_tab): ?>
                          <li class="active"><span><?php echo e($active_tab+1); ?></span></li>
                    <?php else: ?>
                          <li><a href="shop?page=<?php echo e($i+1); ?>"><?php echo e($i+1); ?></a></li>
                    <?php endif; ?>
                    <?php if($active_tab != $pages-1): ?> <li><a href="#">&gt;</a></li> <?php endif; ?>
                    
                          <?php } ?>
                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="filters-placeholder" style="margin-top:80px;"> </div>
          <div class="col-md-3 order-1 mb-5 mb-md-0 filters bg-gray" style="margin-top:80px;">
            <div class="border p-4 rounded mb-4">
              <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
              <ul class="list-unstyled mb-0">
               <?php foreach ($cats as $cat=>$pcs) { ?>
                <li class="mb-1"><a href="#" class="d-flex"><span><?php echo e($cat); ?></span> <span class="text-black ml-auto">(<?php echo e($pcs); ?>)</span></a></li>
               <?php }?>
              </ul>
            </div>

            <div class="border p-4 rounded mb-4">
              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
                <div id="slider-range" class="border-primary"></div>
                <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />
              </div>

              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Size</h3>
                <label for="s_sm" class="d-flex">
                  <input type="checkbox" id="s_sm" class="mr-2 mt-1"> <span class="text-black">Small (2,319)</span>
                </label>
                <label for="s_md" class="d-flex">
                  <input type="checkbox" id="s_md" class="mr-2 mt-1"> <span class="text-black">Medium (1,282)</span>
                </label>
                <label for="s_lg" class="d-flex">
                  <input type="checkbox" id="s_lg" class="mr-2 mt-1"> <span class="text-black">Large (1,392)</span>
                </label>
              </div>

              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Color</h3>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-danger color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Red (2,429)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-success color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Green (2,298)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-info color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Blue (1,075)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-primary color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Purple (1,075)</span>
                </a>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>

    <!--div class="site-section">
      <div class="container">
        <div class="title-section mb-5">
          <h2 class="text-uppercase"><span class="d-block">Discover</span> The Collections</h2>
        </div>
        <div class="row align-items-stretch">
          <div class="col-lg-8">
            <div class="product-item sm-height full-height bg-gray">
              <a href="#" class="product-category">Women <span>25 items</span></a>
              <img src="/images/model_4.png" alt="Image" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="product-item sm-height bg-gray mb-4">
              <a href="#" class="product-category">Men <span>25 items</span></a>
              <img src="/images/model_5.png" alt="Image" class="img-fluid">
            </div>

            <div class="product-item sm-height bg-gray">
              <a href="#" class="product-category">Shoes <span>25 items</span></a>
              <img src="/images/model_6.png" alt="Image" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </div-->
    <style>
     body  .site-section  .popular .item-entry{
    
      max-width: 32%;
   
    }
      @media  screen and (min-width:768px){
        .filters{position: -webkit-sticky;
                position: sticky;
                top: 0;}
      }
      @media  screen and (max-width:1320px){
        .site-section .popular .item-entry{
        max-width: 48.33%!important;
      }}

      @media  screen and (max-width:1000px) and (min-width:768px){
        .site-section .popular .item-entry{
          max-width: unset!important;
        }
        .filters{
          flex: 0 0 41.66667%!important;
          max-width: 41.66667%!important;
        }
        .filtered{
          flex: 0 0 58.33333%!important;
          max-width: 58.33333%!important;
        }
      }
    
      @media  screen and (max-width:768px){
        .site-section .popular .item-entry{
          max-width: unset!important;
        }
      }
    
    
      </style>
      <script>
      function Utils() {

}

Utils.prototype = {
    constructor: Utils,
    isElementInView: function (element, fullyInView) {
        var pageTop = $(window).scrollTop();
        var pageBottom = pageTop + $(window).height();
        var elementTop = $(element).offset().top;
        var elementBottom = elementTop + $(element).height();

        if (fullyInView === true) {
            return ((pageTop < elementTop) && (pageBottom > elementBottom));
        } else {
            return ((elementTop <= pageBottom) && (elementBottom >= pageTop));
        }
    }
};

window.utils = new Utils();
      
window.onload = function(){
  var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
$(window).scroll(function(e){ 
  if(!isMobile){
  var $el = $('.filters'); 
  var isPositionFixed = ($el.css('position') == 'fixed' || $el.css('position') == 'absolute');
  if ($(this).scrollTop() >= 150 && !isPositionFixed){ 
    $('.filters-placeholder').show();
    $('.filters-placeholder').width($el[0].clientWidth-1);
    $('.filters-placeholder').height($el[0].clientHeight-1);
    

    $el.css({'position': 'fixed', 'top': '43px'}); 
    $el.width($('.filters-placeholder').width()-29.425);
  }
  if ($(this).scrollTop() < 150 && isPositionFixed){
    $el.css({'position': 'initial', 'top': 'unset'}); 
    $('.filters-placeholder').hide();
  } else
  if(window.utils.isElementInView($('footer'),false) && $el.css('position') != 'absolute' && isPositionFixed){
    
   
    $el.css({'position': 'absolute', 'top': ($(window).scrollTop() +35)+"px"}); 
  }else if(!window.utils.isElementInView($('footer'),false)  && $el.css('position') == 'absolute' && isPositionFixed){
    $el.css({'position': 'fixed', 'top': '43px'}); 
    $('.filters-placeholder').show();
    $('.filters-placeholder').width($el[0].clientWidth-1);
    $('.filters-placeholder').height($el[0].clientHeight-1);
  }
  }
}); }

        </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/JWLStore/resources/views/shop.blade.php ENDPATH**/ ?>