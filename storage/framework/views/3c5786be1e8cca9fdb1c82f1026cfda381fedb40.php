    

<?php $__env->startSection('page_content'); ?>
    <div class="site-blocks-cover inner-page" data-aos="fade">
      <div class="container">
        <div class="row">
          <div class="col-md-6 ml-auto order-md-2 align-self-start">
            <div class="site-block-cover-content">
            <h2 class="sub-title">#New Winter Collection 2019</h2>
            <h1>Arrivals Sales</h1>
            <p><a href="#" class="btn btn-black rounded-0">Shop Now</a></p>
            </div>
          </div>
          <div class="col-md-6 order-1 align-self-end">
            <img src="/images/asdpor.jpeg" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>
    </div>



    <div class="site-section" style="width:100%;">
      <div class="container popular" style="max-width:none!important;width:85%;">
    

        <div class="row mb-5">
          <div class="col-md-9 order-2 filtered" style="margin-top:-10px;">
           
            <div class="row align">
              <div class="col-md-12 mb-5">
                <div class="d-flex">
                  <?php if(count($products) > 0){ ?>
                  <div class="dropdown mr-1 ml-md-auto">
                   
                  </div>
                  <div class="btn-group">
                    <button type="button" class="btn btn-white btn-sm dropdown-toggle px-4" id="dropdownMenuReference" data-toggle="dropdown">Sorteaza</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                      <a class="dropdown-item sort" order="0">Relevanta</a>
                      <a class="dropdown-item sort" order="2">Pret, mic la mare</a>
                      <a class="dropdown-item sort" order="1">Pret, mare la mic</a>
                    </div>
                  </div>
                  <?php } ?>
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
                   <?php if(count($products)>0): ?>
                    <?php if($active_tab > 0): ?>  <li><a class="prod-nav" next="<?php echo e($active_tab-1+1); ?>">&lt;</a></li> <?php endif; ?>
                    <?php  
                          for($i = 0; $i<$pages; $i++){
                    ?>
                    <?php if($i == $active_tab): ?>
                          <li class="active"><span><?php echo e($active_tab+1); ?></span></li>
                    <?php else: ?>
                          <li><a class="prod-nav" next="<?php echo e($i+1); ?>"><?php echo e($i+1); ?></a></li>
                    <?php endif; ?>
                    
                          <?php } ?>
                          <?php if($active_tab != $pages-1): ?> <li><a class="prod-nav" next="<?php echo e($active_tab+2); ?>">&gt;</a></li> <?php endif; ?>
                    <?php else: ?>
                      <li class="active" style="margin-top: 42px;"><span>0</span></li>
                     <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="filters-placeholder" style="margin-top:80px;"> </div>
          <div class="col-md-3 order-1 mb-5 mb-md-0 filters bg-gray" style="margin-top:80px;">
            <div class="border p-4 rounded mb-4width sel-container">
              <h3 class="mb-3 h6 text-uppercase text-black d-block">Categorii</h3>
              <ul class="list-unstyled mb-0 unselected-cats">
               <?php foreach ($cats as $cat=>$props) { ?>
                <li class="mb-1 cats" id="cat_<?php echo e($props["id"]); ?>"><a class="d-flex text-black"><span><?php echo e($cat); ?></span> <span class="text-black ml-auto">(<?php echo e($props["count"]); ?>)</span></a></li>
               <?php }?>
              </ul>
                <h6 style="margin-top:10px;">Categorii selectate:</h6>
                <div class="selected">
                    <ul class="list-unstyled mb-0 selected-cats">
                    </ul>
                </div>
            </div>

            <div class="border p-4 rounded mb-4 sel-container">
              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Filtreaza dupa pret</h3>
                <div id="slider-range" class="border-black price-filter"></div>
                <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />
              </div>

              <div class="mb-4 size-container">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Marimi</h3>
                
                <?php foreach($sizes as $size){ ?>
                  <label for="s_lg" class="d-flex">
                  <input type="checkbox" id="s_<?php echo e($size->size_id); ?>" class="mr-2 mt-1"> <span class="text-black"><?php echo e($size->description); ?> (<?php echo e($size->size_count); ?>)</span>
                  </label>
                <?php } ?>
              </div>

              <div class="mb-4 unselected-tags">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Etichete</h3>
                
                <?php foreach($tags as $tag){?>
                  <a  class="d-inline-flex color-item align-items-center tag" style="margin: 0 5px;" id="tag_<?php echo e($tag->tag_id); ?>">
                  </span> <span class="text-black">#<?php echo e($tag->name); ?> (<?php echo e($tag->tag_count); ?>)</span>
                </a>
              <?php } ?>
                
              </div>
              <h6 style="margin-top:10px">Etichete selectate:</h6>
                <div class="selected" style="min-height:20px;margin-bottom:10px">

              </div>
              <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg btn-block send-filters" >Aplica Filtre</button>
                  </div>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <style>
        .selected{
          border-bottom:1px solid black;
          min-height: 20px;
        }.tag>span:hover,.cats:hover span{
          color:#ee4266;
        }
        .border-black{
          border:1px solid black;
        }.price-filter>*{
          background: black!important;
        }
        .tag,.cats{
          cursor: pointer;
          color:black!important;
        }
       a{cursor: pointer;}
      </style>
       
      <script>
        /*var jQ = document.createElement('script');
        jQ.src = "js/jquery-3.3.1.min.js";
        document.body.appendChild(jQ);
       jQ.onload = function(){  
        }*/
      </script>
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
   
    }.filters>div{
      background: white;
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


        </script>
      <!--script>
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
  if ($(this).scrollTop() >= 550 && !isPositionFixed){ 
    $('.filters-placeholder').show();
    $('.filters-placeholder').width($el[0].clientWidth-1);
    $('.filters-placeholder').height($el[0].clientHeight-1);
    

    $el.css({'position': 'fixed', 'top': '43px'}); 
    $el.width($('.filters-placeholder').width()-29.425);
  }
  if ($(this).scrollTop() < 550 && isPositionFixed){
    $el.css({'position': 'initial', 'top': 'unset'}); 
    $('.filters-placeholder').hide();
  }/* else
  if(window.utils.isElementInView($('footer'),false) && $el.css('position') != 'absolute' && isPositionFixed){
    
   
    $el.css({'position': 'absolute', 'top': ($(window).scrollTop() +35)+"px"}); 
  }else if(!window.utils.isElementInView($('footer'),false)  && $el.css('position') == 'absolute' && isPositionFixed){
    $el.css({'position': 'fixed', 'top': '43px'}); 
    $('.filters-placeholder').show();
    $('.filters-placeholder').width($el[0].clientWidth-1);
    $('.filters-placeholder').height($el[0].clientHeight-1);
  }*/
  }
}); }

        </script-->
    <?php $__env->stopSection(); ?>

    
<?php $__env->startSection('scripting'); ?>
        <script>
       $(document).ready(function(){   
        window.getparams = {};
        location.search.substr(1).split('&').forEach(function(query){
                window.getparams[query.split('=')[0]]= decodeURIComponent(query.split('=')[1]);
        });
        Object.keys(window.getparams).forEach(function(filter){
          if(filter == "tags"){
            var tags = window.getparams[filter].split(',').map(function(element){return element.trim()});
            console.log(filter,tags);
          }

          if(filter == "tags"){
            var tags = window.getparams[filter].split(',').map(function(element){return element.trim()});
           tags.forEach(function(tag){
            var selected_tag = $("#tag_"+tag).clone();
              selected_tag.on('click',removeTagCallback);
              console.log( $("#tag_"+tag),"#tag_"+tag);
              $("#tag_"+tag).closest('.sel-container').find('.selected').append(selected_tag);
              $("#tag_"+tag).remove();
           }) 
          }
          if(filter == "prices"){
            var min = window.getparams[filter].split(',')[0];
            var max = window.getparams[filter].split(',')[1];
            $( "#slider-range" ).slider({values:[min,max]})
            $( "#amount" ).val(min+" Lei - "+max+" Lei");
          }

          if(filter == "cats"){
            var tags = window.getparams[filter].split(',').map(function(element){return element.trim()});
           tags.forEach(function(tag){
              var selected_cat = $('#cat_'+tag).clone();
              selected_cat.on('click',removeCatCallback);
              $('#cat_'+tag).closest('.sel-container').find('.selected>ul').append(selected_cat);
              $('#cat_'+tag).remove();
           })
          }

          if(filter == "sizes"){
            var tags = window.getparams[filter].split(',').map(function(element){return element.trim()});
            tags.forEach(function(tag){
              $('#s_'+tag)[0].checked = true;
            });
          }

        })})
$('.sort').on('click',function(ev){
  var selected_cats =  $('.selected .cats').map(function(index,element){return element.id.split('_')[1];}).toArray();
            var selected_tags =  $('.selected .tag').map(function(index,element){ return element.id.split('_')[1];}).toArray();
            var selected_sizes  = $('.size-container input:checked').map(function(index,element){return element.id.split('_')[1]}).toArray();
            var price_range = $('#amount').val().split(' - ').map(function(val,index){return val.split(' ')[0]});
           
           console.log( selected_tags,selected_tags.length);
           var url = "/shop";
           url = add_filter_to_url(url,"cats",selected_cats);
           url = add_filter_to_url(url,"tags",selected_tags);
           url = add_filter_to_url(url,"sizes",selected_sizes);
           url = add_filter_to_url(url,"prices",price_range);
           url = add_filter_to_url(url,"sort",$(this).attr("order"));
            window.location.href = url;
})
$('.size-container>label>span').on('click',function(ev){  $(this).siblings().click(); })

          function addTagCallback(ev){
              var selected_tag = $(this).clone();
              selected_tag.on('click',removeTagCallback);
              $(this).closest('.sel-container').find('.selected').append(selected_tag);
              $(this).remove();
          }

          function addCatCallback(ev){
            var selected_cat = $(this).clone();
            selected_cat.on('click',removeCatCallback);
              $(this).closest('.sel-container').find('.selected>ul').append(selected_cat);
              $(this).remove();
          }

          
          function removeTagCallback(ev){
              var removed_tag = $(this).clone();
              removed_tag.on('click',addTagCallback)
              $('.unselected-tags').append(removed_tag);
              $(this).remove();
          }
          function removeCatCallback(ev){
            var removed_cat = $(this).clone();
              removed_cat.on('click',addCatCallback)
              $('.unselected-cats').append(removed_cat);
              $(this).remove();
          }

          function add_filter_to_url(url, filter_name,filter_values){
            if(/.\?./.test(url)){
              url+= filter_values.length>0?"&"+filter_name+"="+encodeURIComponent(filter_values.toString()):"";
            }else{
              url+= filter_values.length>0?"?"+filter_name+"="+encodeURIComponent(filter_values.toString()):"";
            }

            return url;
          }
          $('.tag').on('click',addTagCallback) 
          $('.cats').on('click',addCatCallback);
          
          $('.send-filters').on('click',function(ev){
            var selected_cats =  $('.selected .cats').map(function(index,element){return element.id.split('_')[1];}).toArray();
            var selected_tags =  $('.selected .tag').map(function(index,element){ return element.id.split('_')[1];}).toArray();
            var selected_sizes  = $('.size-container input:checked').map(function(index,element){return element.id.split('_')[1]}).toArray();
            var price_range = $('#amount').val().split(' - ').map(function(val,index){return val.split(' ')[0]});
           
           console.log( selected_tags,selected_tags.length);
           var url = "/shop";
           url = add_filter_to_url(url,"cats",selected_cats);
           url = add_filter_to_url(url,"tags",selected_tags);
           url = add_filter_to_url(url,"sizes",selected_sizes);
           url = add_filter_to_url(url,"prices",price_range);
            window.location.href = url;
          })

          $('.prod-nav').on('click',function(ev){
            var selected_cats =  $('.selected .cats').map(function(index,element){return element.id.split('_')[1];}).toArray();
            var selected_tags =  $('.selected .tag').map(function(index,element){ return element.id.split('_')[1];}).toArray();
            var selected_sizes  = $('.size-container input:checked').map(function(index,element){return element.id.split('_')[1]}).toArray();
            var price_range = $('#amount').val().split(' - ').map(function(val,index){return val.split(' ')[0]});
           
           var url = "/shop";
          
           url = add_filter_to_url(url,"page",[$(this).attr('next')]); 
            if(window.location.href.split('?').length > 1 ){
                url = add_filter_to_url(url,"cats",selected_cats);
              url = add_filter_to_url(url,"tags",selected_tags);
              url = add_filter_to_url(url,"sizes",selected_sizes);
              url = add_filter_to_url(url,"prices",price_range);
            }
            console.log(url)
            window.location.href = url;
          })
          </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base_nofooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/JWLStore/resources/views/shop.blade.php ENDPATH**/ ?>