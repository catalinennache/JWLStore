@extends('layouts.base_empty')

@section('page_content')

    <div class="site-section">
      <div class="container">
        
        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0" style="margin:0 auto;">
            <h2 class="h3 mb-3 text-black text-center">Express yourself boundless</h2>
            <div class="p-3 p-lg-5 border">
            

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" placeholder="Email" class="form-control" id="email" name="email">
                   </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="password" placeholder="Parola" class="form-control" id="pass" name="password">
                </div>
              </div>



              <span class="warn email">Datele de autentificare sunt invalide. Va rugam reincercati!</span>
           

             

              <div class="form-group">
                <button class="btn btn-primary btn-lg btn-block login" onclick="">Intra in cont</button>
              </div>

             
              <div class="p-4 text-center" role="alert">
                Nu ai cont? <a href="/register">Apasa aici</a> pentru inregistrare
              </div>
            </div>
          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>

  <script>

   window.onload = function(){ 
     
    window.onkeypress = function(ev){
      if(ev.keyCode == 13){
        callback();
      }
    }
    $('.login').on('click',callback);
     
     }


     var callback = function(){


$.ajax({
  type:'POST',
    url:'/login',
    data:{email:$('#email').val(),password:$('#pass').val(), _token: "{{ csrf_token() }}"},
   
  success:function(data){
    if(!data.errors){
      window.location.href = '/';
    }else{
      var error = data.errors;
      errors.array.forEach(element => {
          element.forEach(elem=>{
             console.log(elem);
          });
      });
      //alert(error);
    }
  },
  error:function(data){
    var errors = (data.responseJSON).errors;
    console.log(errors);
    Object.keys(errors).forEach(function(key){
        if(errors[key].length > 0)
            errors[key].forEach(function(elem){
              console.log('.warn.'+key,$('.warn.'+key),$('.warn.'+key).parent())
              $('.warn.'+key).parent().addClass('show');
              $('.warn.'+key).parent().parent().css('margin-bottom','10px');
            })
            else{
              $('.warn.'+key).parent().addClass('show');
            
            }
    });
    console.log(data);
      
  }
})
};
  </script>
  <style>
    .warn{
      display: none;
    }
   .show .warn{
     display: block;
     color: red;
     padding:10px;
     padding-bottom: 0;
   }
   
  </style>
  @endsection

