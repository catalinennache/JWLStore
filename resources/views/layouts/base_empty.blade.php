<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Silver Boutique</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head><script>
    
    try{
      window.jqLoaded = new (function(){
          this.posted =[],
          this.triggered=false,
          this.subscribe=function(callback){
            if(this.triggered == true)
               callback();
               else
            this.posted.push(callback);
            console.log(">> callback registered ",this.posted);
          }.bind(this),
          this.fire=function(){
            this.triggered = true;
            for(var i = 0; i<this.posted.length;i++) 
                this.posted[i]();
            console.log(">> fired");    
          }.bind(this)
        })
      
      //document.getElementById('jq').onload = window.jqLoaded.fire;
    }catch(e){ console.log(e)}
    </script>
  <body >
    <script>
       var script = document.createElement('script');
      script.onload =window.jqLoaded.fire;
      script.src = "js/jquery-3.3.1.min.js";
      document.body.appendChild(script);
      </script>
  
  <div class="site-wrap">
    

    <div class="site-navbar bg-white py-2">

      <div class="search-wrap">
        <div class="container">
          <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
          <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
          </form>  
        </div>
      </div>
      <style>
            .dapper{
                padding: 10px 10px;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #25262a;
            font-size: 15px;
            text-decoration: none !important;
            }
        </style>
      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <div class="logo">
            <div class="site-logo">
              <a href="/" class="js-logo-clone">Silver Boutique</a>
            </div>
          </div>
          <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
              <ul class="site-menu js-clone-nav d-none d-lg-block">
                  <li><a href="#">Home</a></li>
                  <li class="has-children active">
                    @if(!isset($GLOBALS['header_cats'])) <a href="/shop">Catalog</a> @else
                    <a >Catalog</a>
                    @endif
                    @if(isset($GLOBALS['header_cats']))
                     <ul class="dropdown">
                      <li><a href="/shop">Toate</a></li>
                     
                       @foreach ($GLOBALS['header_cats'] as $id => $category)
                          <li><a href="/shop?cats={{$id}}">{{$category}}</a></li>
                       @endforeach
                   
                       <!--li><a href="#">Menu Two</a></li>
                       <li><a href="#">Menu Three</a></li>
                       <li class="has-children">
                         <a href="#">Sub Menu</a>
                         <ul class="dropdown">
                           <li><a href="#">Menu One</a></li>
                           <li><a href="#">Menu Two</a></li>
                           <li><a href="#">Menu Three</a></li>
                         </ul>
                       </li-->
                     </ul>
                     @endif
                    </li>
                    <li><a href="/contact">Contact</a></li>
                @if (Auth::user() == null)
                
                <li><a href="/login" class="icons-btn d-inline-block js ">Login</a></li>
               <li> <a href="/register" class="icons-btn d-inline-block js ">Register</a></li>
               @else
               <li>  <a href="/profile" class="icons-btn d-inline-block ">{{Auth::user()->name?Auth::user()->name:"Profile"}}</a> </li>
               <li> <a href="/logout" class="icons-btn d-inline-block ">Log Out</a></li>
               @endif
              </ul>
            </nav>
          </div>
          <div class="icons">
           
            <!--a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a-->
            <a href="/cart" class="icons-btn d-inline-block bag">
              <span class="icon-shopping-bag"></span>
              <?php if(session('cart_products')){?>
                <span class="number"><?php echo count(session('cart_products'));?></span>
             <?php } ?>
            </a>
            <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>
          </div>
        </div>
      </div>
    </div>

    @section('page_content')
        
    @show


    

  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
  @section('scripting')

  @show
    
  </body>
</html>