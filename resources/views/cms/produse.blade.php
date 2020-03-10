@extends('cms.base')

@section('content')

<div>
  
    <div class="grid">
        <?php $i = 0; ?>
        @foreach ($columns_prod as $column)
        <div class="blocks">

        <label prod_id="{{$prod->product_id}}" style="margin:0 auto;">{{$column}}</label><br>
        <textarea>{{$prod->$column}}</textarea>

       </div>
        @endforeach
        
      </div>
    <table>
        <thead>
           
            <th class="ed"> Edit </th>
            <th class="del"> Delete </th>
        </thead>
        <tbody>
        
        </tbody>
</div>
<style>
.grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: .5rem;
  padding: .5rem;
  grid-auto-rows: minmax(100px, auto);
  min-height: calc(100vh - 1rem);
  width:50%;
  margin:0 auto;


}
 .blocks{
 }

    </style>
<a style="position:fixed; bottom:10px; right:10px;" href="/admin/delete?table=Products&keycode=product_id&key={{$prod->product_id}}"> Sterge produs </a>

@endsection

@section('scripting')
    <script>
 
               var labels =  $('label').filter(function(index,element){
                    return element.innerHTML.includes("image");
                })

                console.log(labels);
                var content = labels.parent().find('textarea');
                labels.each(function(index,element){
                    if($(element).parent().find('textarea').val()){

                        var img = document.createElement('img');
                        img.classList.add("prev");
                        img.src = "http://localhost:8000/images/products/product_"+$(element).attr("prod_id")+"/small/"+$(element).parent().find('textarea').val();
                        $(element).parent().append(img)
                       
                    }
                    var file_input = document.createElement('input');
                    file_input.type= "file";
                    file_input.name= element.innerHTML;
                    $(element).parent().append(file_input);

                    $(element).parent().find('textarea').remove();

                })
         
    </script>
@endsection


