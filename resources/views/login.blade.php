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
                  <input type="text" placeholder="Email" class="form-control" id="c_companyname" name="c_companyname">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" placeholder="Password" class="form-control" id="c_companyname" name="c_companyname">
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-primary btn-lg btn-block login" onclick="">Log In</button>
              </div>

              <div class="border p-4 rounded text-center artefact" style="background: #ee4266; color: whitesmoke;" role="alert">
                New customer? <a style="" href="/register">Click here</a> to get started
              </div>
              <div class="p-4 text-center" role="alert">
                Forgotten password? <a href="/login">Click here</a> to recover
              </div>
            </div>
          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>

  <script>
      $('.login').on('click',function(){
          var email = $(this).closest('.form-group').find('input')[0];
          var password = $(this).closest('.form-group').find('input')[1];
          $.ajax({
            type:'POST',
            url:'/login',
            data:{email:email,password:password, _token: "{{ csrf_token() }}",},
            success:function(data){
              if(data.success){
                window.location.href = "/";
              }else{
                var error = data.err;
                alert(error);
              }
            }
          })
      });
    </script>

    @endsection
    