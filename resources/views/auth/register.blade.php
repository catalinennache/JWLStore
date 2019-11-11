@extends('layouts.base')

@section('page_content')

    <div class="site-section">
      <div class="container">
        
        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0" style="margin:0 auto;">
            <h2 class="h3 mb-3 text-black text-center">Express yourself boundless</h2>
            <div class="p-3 p-lg-5 border">
              
                <div class="form-group row">
                    <div class="col-md-12">
                      <input type="text" placeholder="Name" class="form-control" id="name" name="name">
                    </div>
                  </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" placeholder="Email" class="form-control" id="email" name="email">
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
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-primary btn-lg btn-block register" onclick="">Sign up</button>
              </div>

              <div class="border p-4 rounded text-center" role="alert">
                Have we met before? <a href="/login">Click here</a> to log in
              </div>
             
            </div>
          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>

  <script>
   window.onload = function(){ $('.register').on('click',function(){
        $.ajax({
          type:'POST',
          url:'/register',
          data:{email:$('#email').val(),
                password:$('#pass').val(),
                name:$('#name').val(),
                password_confirmation:$('#passc').val(),
                 _token: "{{ csrf_token() }}",},
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
                        console.log(elem);
                    })
                    else
                    console.log(errors[key]);
            })
              
          }
        })
    });}
  </script>
  @endsection