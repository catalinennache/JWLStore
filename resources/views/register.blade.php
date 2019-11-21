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
                  <input type="text" placeholder="Email" class="form-control" id="email" name="c_companyname">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="password" placeholder="Password" class="form-control" id="pass" name="c_companyname">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="password" placeholder="Password Confirm" class="form-control" id="passc" name="c_companyname">
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-primary btn-lg btn-block" onclick="window.location='/'">Sign up</button>
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

