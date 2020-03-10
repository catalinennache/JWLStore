@extends('layouts.base')

@section('page_content')
<input type="hidden" value="" name="order_stamp">
    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class=" p-1 " role="alert">
                  <span style="display:block; text-align:center;font-size:32px;color:black;width:50%;border-bottom:1px dashed black; margin:0 auto;">Checkout</span>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-5 mb-md-0 checkout-details" >
            <h2 class="h3 mb-3 text-black">Detalii Facturare</h2>
            <div class="p-3 p-lg-5 " style="background:white;border:1px dashed black!important">
              <div class="billing">
             <?php $auth = !!Auth::user();?>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="c_fname" class="text-black">Nume <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_fname" name="c_fname" value="<?php echo $auth?Auth::user()->first_name:"";?>">
                </div>
                <div class="col-md-6">
                  <label for="c_lname" class="text-black">Prenume <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_lname" name="c_lname" value="<?php echo $auth?Auth::user()->last_name:"";?>">
                </div>
              </div>

              <div class="form-group row">
               
              </div>
             <div class="location_wrp">  
              <div class="form-group row">
                <div class="col-md-6 state_select">
                  <label for="c_state_country" class="text-black">Judet <span class="text-danger">*</span></label>
                  <select id="c_state_country" class="form-control" name="c_state_country" def="<?php echo $auth?Auth::user()->state:"";?>">
                    @if(!isset(Auth::user()->state)) <option value="1">Selectati un judet</option>  @endif   
                  
                  </select> 
                  <script>
                    document.onreadystatechange = function(ev){
                          var states = ["Alba","Arad","Arges","Bacau","Bihor","Bistrita-Nasaud","Botosani","Brasov","Braila","Bucuresti","Buzau","Caras-Severin","Cluj","Constanta","Covasna","Calarasi","Dolj","Dambovita","Galati","Giurgiu","Gorj","Harghita","Hunedoara","Ialomita","Iasi","Ilfov","Maramures","Mehedinti","Mures","Neamt","Olt","Prahova","Satu Mare","Sibiu","Suceava","Salaj","Teleorman","Timis","Tulcea","Vaslui","Vrancea","Valcea"]
                          var select = $('.state_select select');
                          select.on('change',function(ev){
                            if(!window.ajxinprogress) {
                              $(ev.target).closest('.location_wrp').find('.cty')[0].innerHTML = "<option> Procesare, va rugam asteptati </option>";
                        
                              console.log(ev.target.selectedOptions[0].value);
                           window.ajxinprogress =  $.ajax({
                               url:"/fetchCities",
                               data:{state:ev.target.selectedOptions[0].value},
                               success:function(dataset){
                                $(ev.target).closest('.location_wrp').find('.cty')[0].innerHTML = "";
                                  var localitati =  Object.entries(JSON.parse(dataset));
                                  if(localitati.length == 0){
                                    $(ev.target).closest('.location_wrp').find('.cty')[0].innerHTML = "<option> Descarcarea oraselor a esuat </option>";
                                  }else{
                                    $(ev.target).closest('.location_wrp').find('.cty')[0].innerHTML = "<option  value=\"\"> Selectati orasul </option>";

                                  }
                                  localitati.forEach(function(element,index){
                                    //console.log(element)
                                   element =  element[1];
                                   element = element.split(',')
                                  var option = document.createElement('option');
                                    option.value = (element[1].replace("\"","").replace("\"",""));
                                    option.innerText = (element[1].replace("\"","").replace("\"",""));
                                  // select[0].appendChild(option);
                                  $(ev.target).closest('.location_wrp').find('.cty')[0].append(option)
                                  })
                                  window.ajxinprogress = false;
                               },
                               error:function(){
                                $(ev.target).closest('.location_wrp').find('.cty')[0].innerHTML = "<option> Descarcarea oraselor a esuat </option>";
                        
                                 window.ajxinprogress = false;
                               }
                             })}
                          })
                        /*  var option = document.createElement('option');
                            
                            option.innerText = "Selectati un judet";
                            select.append(option);*/
                            
                          states.forEach(function(element,index){
                            var option = document.createElement('option');
                            option.value = element;
                            option.innerText = element;
                           // select[0].appendChild(option);
                            if(select.find('option[value="'+option.value+'"]').length == 0){
                              select.append(option)}
                          })
                        //  try{ $('.state_select select option[value="'+$('.state_select select').attr('def')+'"]')[0].selected = "selected" ;
                        // }catch(e){}

                        $('.cty').on('change',function(ev){
                       console.log("cty change detected ");
                      if(!window.ajxinprogress) {
                        window.ajxinprogress = true;
                        console.log("CTY change accepted");
                        $(ev.target).closest('.location_wrp').find('.str')[0].innerHTML = "<option> Procesare, va rugam asteptati </option>";
                        
                        if(ev.target.value != "Bucuresti"){
                         //    console.log(ev.target);
                       
                          $.ajax({
                               url:"/fetchStreets",
                               data:{city:ev.target.selectedOptions[0].value,
                                      state:$(ev.target).closest('.location_wrp').find('.state_select select')[0].selectedOptions[0].value
                                    },
                               success:function(dataset){
                                $(ev.target).closest('.location_wrp').find('.str')[0].innerHTML = "";
                                  var strazi =  Object.entries(JSON.parse(dataset))
                                  if(strazi.length == 0){
                                    $(ev.target).closest('.location_wrp').find('.str')[0].innerHTML = "<option> Descarcarea strazilor a esuat </option>";
                                  }else{
                                    $(ev.target).closest('.location_wrp').find('.str')[0].innerHTML = "<option value=\"neselectat\"> Selectati strada </option>";
                        
                                  }
                                  window.str = [];
                                  strazi.forEach(function(element,index){
                                   // console.log(element)
                                   element =  element[1];
                                   element = element.split(',')
                                  var option = document.createElement('option');//console.log(element);

                                    option.value = (element[2].replace("\"","").replace("\"",""));
                                    option.innerText = (element[2].replace("\"","").replace("\"",""));
                                  // select[0].appendChild(option);
                                  if((element[2].replace("\"","").replace("\"","")).length>1){
                                      var ok = !window.str[option.value];
                                      if(ok){
                                           window.str[option.value] = 1;
                                           $(ev.target).closest('.location_wrp').find('.str')[0].appendChild(option);
                                      }
                                      
                                     // var sync = new Promise(function(resolve,reject){
                                    /* $( $(ev.target).closest('.location_wrp').find('.str')[0]).find('option').each(function(index,element){
                                       console.log("comparing ",option.value,element.value);
                                      if(element.isEqualNode(option))
                                          ok = false;

                                        if(!ok){
                                          console.log("rejected");
                                          //reject();
                                          return false;
                                          
                                        }
                                          if(index ==  $($(ev.target).closest('.location_wrp').find('.str')[0]).find('option').length -1 && ok){
                                            $(ev.target).closest('.location_wrp').find('.str')[0].appendChild(option);
                                            console.log("accepted");
                                            //resolve(true);
                                          }
                                     
                                     });// });*/
                                     // try{ await sync }catch(e){}
                                    }

                                    if(index == strazi.length -1 ){
                                      window.ajxinprogress = false;
                                    }
                                  })
                                  
                               },
                               error:function(){
                                $(ev.target).closest('.location_wrp').find('.str')[0].innerHTML = "<option> Descarcarea strazilor a esuat </option>";
                        
                                 window.ajxinprogress = false;
                               }
                             })

                            }else{

                              var ctx =  $(ev.target);
                              if(!window.encodedStreets){
                              var script = document.createElement('script');
                                script.src = "js/streets.b.js";
                              
                                $(script).on('load',function(ev){
                                  ctx.closest('.location_wrp').find('.str')[0].innerHTML = "<option value=\"neselectat\"> Selectati strada </option>";
                                  ctx.closest('.location_wrp').find('.str')[0].innerHTML += window.encodedStreets;
                                })
                                document.body.appendChild(script);
                              }else{
                                ctx.closest('.location_wrp').find('.str')[0].innerHTML = "<option value=\"neselectat\"> Selectati strada </option>";
                                ctx.closest('.location_wrp').find('.str')[0].innerHTML += window.encodedStreets;
                              }
                              window.ajxinprogress = false;
                              

                            }
                             
                        }
                    })

                        }


                   
                    </script>
                </div>
                <div class="col-md-6">
                  <label for="c_postal_zip" class="text-black">Cod Zip <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip" value="<?php echo $auth?Auth::user()->zip:"";?>">
                </div>
              </div>


              <div class="form-group row">
                <div class="col-md-6">
                  <label for="c_address_nr" class="text-black">Oras <span class="text-danger">*</span></label>
                  <select id="c_city" class="form-control cty" name="c_city">
                    
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="c_address" class="text-black">Strada <span class="text-danger">*</span></label>
                  <!--input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address" value="<?php echo $auth?Auth::user()->address:"";?>"-->
                  <script>
                  
                    </script>
                  
                  <select id="c_address" class="form-control str" name="c_address">
                    
                  </select>
                </div>
                
              </div>
             </div>
              <div class="form-group" style="">
                <input type="text" class="form-control" placeholder="Numar, bloc, scara  (optional)" name="c_address_sec" value="<?php echo $auth?Auth::user()->address_sec:"";?>">
              </div>

             

              <div class="form-group row">
                <div class="col-md-6">
                  <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="c_email_address" name="c_email_address" value="<?php echo $auth?Auth::user()->email:"";?>">
                </div>
                <div class="col-md-6">
                  <label for="c_phone" class="text-black">Numar de telefon <span class="text-danger">*</span></label>
                  <input type="text" class="form-control phone" id="c_phone" name="c_phone" placeholder="Phone Number" value="<?php echo $auth?Auth::user()->phone_number:"";?>">
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </div>
              <div class="form-group  mb-5" style="">
                <label for="c_payment_method" class="text-black">Modalitate plata<span class="text-danger">*</span></label>
                
                <select id="c_payment_method" class="form-control str" name="c_payment_method">
                    <option value="">Selecteza modalitatea plata</option>
                    <option value="1"> Card</option>
                    <option value="2"> Ramburs </option>
                    @if(Session::get('SU'))
                      <option value="-1"> Ramburs Gratis (Plata transport la destinatar) </option>
                      <option value="-2"> Ramburs Gratis (Plata transport la expeditor)</option>
                      @endif
                </select>
              </div>
            </div>
<?php if(!$auth){ ?>
              <div class="form-group">
                <label for="c_create_account" class="text-black" data-toggle="collapse" href="#create_an_account" role="button" aria-expanded="false" aria-controls="create_an_account"><input type="checkbox" class="create_acc" value="1" id="c_create_account" name="c_create_account"> Create an account?</label>
                <div class="collapse" id="create_an_account">
                  <div class="py-2">
                    <p class="mb-3">Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p>
                    <div class="form-group">
                      <label for="c_account_password" class="text-black">Account Password</label>
                      <input type="password" class="form-control" id="c_account_password" name="c_account_password" placeholder="">
                      <span class=""> Parola trebuie sa aiba minim 6 caractere. </span>
                    </div>
                  </div>
                </div>
              </div> 
          <?php } ?>


              <div class="form-group shipping">
                <label for="c_ship_different_address" class="text-black" data-toggle="collapse" href="#ship_different_address" role="button" aria-expanded="false" aria-controls="ship_different_address"><input type="checkbox" class="diff_shipping" value="1" id="c_ship_different_address" name="c_ship_different_address"> Adresa de livrare e diferita de cea de facturare</label>
                <div class="collapse" id="ship_different_address">
                  <div class="py-2">

                    <div class="form-group row">
                      <div class="col-md-6">
                        <label for="c_diff_fname" class="text-black">Nume <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_fname" name="c_diff_fname">
                      </div>
                      <div class="col-md-6">
                        <label for="c_diff_lname" class="text-black"> Prenume <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_lname" name="c_diff_lname">
                      </div>
                    </div>

                
                    <div class="location_wrp">
                      <div class="form-group row">
                      <div class="col-md-6 state_select">
                        <label for="c_diff_state_country" class="text-black">Judet<span class="text-danger">*</span></label>
                       <select id="c_diff_state_country" class="form-control">
                            <option value="">Selectati un judet</option>    
                         
                          </select> 
                    </div>
                      <div class="col-md-6">
                        <label for="c_diff_postal_zip" class="text-black">Posta / Zip <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_postal_zip" name="c_diff_postal_zip">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-6">
                        <label for="c_diff_city" class="text-black">Oras <span class="text-danger">*</span></label>
                        <select id="c_diff_city" class="form-control cty" name="c_diff_city">
                    
                        </select>
                      </div>

                      <div class="col-md-6">
                        <label for="c_diff_address" class="text-black">Strada <span class="text-danger">*</span></label>
                        <select id="c_diff_address" class="form-control str" name="c_diff_address">
                    
                      </select>
                      </div>
                     
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control" name="c_diff_address_sec" placeholder="Numar, Bloc, Scara, Apartament (optional)">
                    </div>
                    </div>
                  

                    <div class="form-group row mb-5">
                      
                      <div class="col-md-6">
                        <label for="c_diff_phone" class="text-black">Numar de telefon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control phone" id="c_diff_phone" name="c_diff_phone" placeholder="Phone Number">
                      </div>
                    </div>
                    

                  </div>

                </div>
              </div>

              <div class="form-group">
                <label for="c_order_notes" class="text-black">Notite Comanda</label>
                <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Scrie notitele aici..."></textarea>
              </div>
              <div class="row" style="display:block;height:50px; margin-top:30px;">
                <div class="col-md-3" style="float:right">
                  <button class="btn btn-primary btn-lg btn-block finish-checkout" onclick="">Urmatorul Pas</button>
                </div>
                
              </div>
            </div>
          
          </div>
        
          </div>
         
        </div>
        <!-- </form> -->
      </div>
    </div>
   <style>
     .wrong{
       border-color: red;
     }.red{
       color:red;
     }
     </style>
    <script>
      function isStandardSelected(val){
         return (val.indexOf("Selectati orasul")>=0 || val.indexOf("Selectati un judet") >= 0 || val.indexOf("Selecteza modalitatea plata") >= 0)
      }
      function checkData(){
          var billing_fields = $('.text-danger').closest('div').find('input,select')
         var shipping_fields =  billing_fields.filter('.shipping *');
         billing_fields = billing_fields.filter('.billing *');
       billing_fields =  billing_fields.add($('create_acc'));
        console.log(billing_fields);
        console.log(shipping_fields);

       for(var i = 0; i< billing_fields.length;i++){
          (function(index,element){
            try{
              var val =  element.type == 'select-one'?$(element.selectedOptions[0]).val():element.value;
              if((""+val).length == 0 || isStandardSelected(val)){
               // console.log((""+val).length == 0 || isStandardSelected(val),(""+val).length,isStandardSelected(val))
            
                  element.classList.add("wrong"); }
                
                else{
                  element.classList.remove("wrong");
                }

                  
              if(element.classList.contains('phone')){
                 try{  var vector = val.split('');
                      var first = vector.shift();
                 
                var ok = ! (vector.find(function(value,index){  return isNaN(parseInt(value))}));
           
                 } catch(e){console.log(e)} console.log(ok,"result");
                
                 var expected_digits = (first == "+"?12:10) 

                  if( val.length != expected_digits || !ok || (first.charAt(0)!= "+" && isNaN(parseInt(first.charAt(0))))){
                    $(element).addClass("wrong");
                  }else{
                      element.classList.remove("wrong");
                  } 
                }  
              
            
             
              
              //  console.log(val);
            }catch(e){
              element.classList.add("wrong");
            }
          })(i,billing_fields.get(i));
        }

        if($(".create_acc").is(":checked")){
               if( $("#c_account_password").val().length < 6){
                  $("#c_account_password").addClass("wrong");
                }else{
                  $("#c_account_password").removeClass("wrong");
                }
                console.log("inn ",element,element.checked,$("#c_account_password").val(),$("#c_account_password").val().length);
              }

        if($('.diff_shipping').is(':checked')){
     
          
       for(var i = 0; i< shipping_fields.length;i++){
          (function(index,element){
            try{
              var val =  element.type == 'select-one'?$(element.selectedOptions[0]).val():element.value;
              if((""+val).length == 0 || isStandardSelected(val)){
               // console.log((""+val).length == 0 || isStandardSelected(val),(""+val).length,isStandardSelected(val))
            
                  element.classList.add("wrong");  }
                
                else{
                  element.classList.remove("wrong");
                }

                  
            if(element.classList.contains('phone')){
                 try{  var vector = val.split('');
                      var first = vector.shift();
                 
                var ok = ! (vector.find(function(value,index){  return isNaN(parseInt(value))}));
           
                 } catch(e){console.log(e)} console.log(ok,"result");
                
                var expected_digits = (first == "+"?12:10) 

                 if( val.length != expected_digits || !ok || (first.charAt(0)!= "+" && isNaN(parseInt(first.charAt(0))))){
                  $(element).addClass("wrong");}
                  else{
                    element.classList.remove("wrong");
                } 
                }  
               // console.log(val);
            }catch(e){
              element.classList.add("wrong");
            }
          })(i,shipping_fields.get(i));
        }


        

      } 
        return !$('.wrong').length;}
      window.onload = function(){

        $('.payment_option').on('click',function(ev){
          $('.collapse.show').removeClass('show');
           $('.collapse.show').parent().find('.d-block').addClass('collapsed');

        })

        $('.finish-checkout').on('click',function(ev){
          var ok = checkData();
          if(ok){
            var form = document.createElement('form');
            form.method = "POST";
            form.action = "/checkout";
            form.style.display = "none";
            var buffer = "";
            $('.checkout-details input,.checkout-details select, textarea').each(function(index,element){
                console.log(element.name,element.type == "checkbox"?element.checked:element.value);
                buffer += element.name+"\n";
          //     console.log(element.type);
                if(element.type == "select-one"){
                  var input = document.createElement('input');
                  //console.log(element,element.selectedOptions);
                  input.name = element.name;
                  input.type = "text";
                  input.value = element.selectedOptions.length>0?element.selectedOptions[0].value:"";
                
                  element = input;
                }
                  
                form.appendChild($(element).clone()[0]);
                if(index == $('.checkout-details input,.checkout-details select,textarea').length - 1){
                  document.body.appendChild(form);
                  form.submit();
                  console.log(buffer);
                }
            })
          }else{

          }

        })
        $('.state_select select').prop('selectedIndex',0);
      }

    </script>


    @endsection