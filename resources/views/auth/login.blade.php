@extends('layouts.base_nofooter')

@section('page_content')
    <div class="site-section">
      <div class="container">
        
        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0" style="margin:0 auto;">
            <h2 class="h3 mb-3 text-black text-center">Express yourself boundless</h2>
            <div class="p-3 p-lg-5 border">
              

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" placeholder="Email" class="form-control" id="email" name="c_companyname">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input placeholder="Password" type="password" class="form-control" id="pass" name="c_companyname">
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

  <style>
    .artefact{
      background: #ee4266; color: whitesmoke;
      cursor: default;
    }
    .artefact>a{
      color: white;
      transition: .3s linear!important;
      cursor: pointer;
    }
    .artefact:hover{
      transition: .3s linear;
      color:#CCC!important;
      background: #af2a47!important;
    }
    .artefact:hover>a{
      text-shadow:  0 0 5px #FFF;
    }
    @media screen and (max-width:600px) {
      .artefact{
      transition: .3s linear;
      color:#CCC!important;
      background: #af2a47!important;
    }
    .artefact>a{
      text-shadow:  0 0 3px #FFF;
    }
    }

  </style>
  
  <script>
    window.onload = function(){    $('.login').on('click',function(){
          var email = $(this).closest('.form-group').find('input')[0];
          var password = $(this).closest('.form-group').find('input')[1];
          $.ajax({
            type:'POST',
            url:'/login',
            data:{email:$('#email').val(),password:$('#pass').val(), _token: "{{ csrf_token() }}",},
            success:function(data){
              if(!data.errors){
                window.location.href = '/';
              }else{
                var error = data.errors;
                //alert(error);
              }
            }
          })
      });};
    </script>
    @endsection
    