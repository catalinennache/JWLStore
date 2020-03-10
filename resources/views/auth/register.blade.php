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
                  <span class="warn email">Email-ul trebuie sa fie o adresa valida.</span>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="password" placeholder="Password" class="form-control" id="pass" name="password">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="password" placeholder="Password Confirm" class="form-control" id="passc" name="password_confirmation">
                  <span class="warn password">Parola trebuie sa fie de cel putin 6 caractere si sa se potriveasca cu confirmarea.</span>
   
                </div>
                           
              </div>

             

              <div class="form-group">
                <button class="btn btn-primary btn-lg btn-block register">Inregistreaza-te</button>
              </div>

              <div class="border p-4 rounded text-center" role="alert">
                Ne-am mai intalnit? <a href="/login">Apasa aici</a> pentru logare
              </div>
             
            </div>
          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>

  <script>
    var callback = function(){
      console.log(">> ")
        $.ajax({
          type:'POST',
          url:'/register',
          data:{email:$('#email').val(),
                password:$('#pass').val(),
                password_confirmation:$('#passc').val(),
                 _token: "{{ csrf_token() }}",},
          success:function(data){
            try{
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
            } }catch(e){window.location.reload();}
          },
          error:function(data){
            try{
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
            })
            }catch(e){window.location.reload()}
          }
        })
    };
   window.onload = function(){ 
    window.onkeypress = function(ev){
      if(ev.keyCode == 13){
        callback();
      }
    }
    $('.register').on('click',callback);

    console.log("asd"); 
    
     }
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