@extends('layouts.kingsbridge')
@section('content')

<section class="section-sm">
    <div class="container">
@if(session('success'))
<div class="mt-3 alert alert-success">
 <span> {{ session('success') }} </span>
</div>
@endif
      <form action="{{ route('user.update_carhire', [$listing->id, $vehicle->id])}}" method="POST" id="step-form-horizontal" class="step-form-horizontal" enctype="multipart/form-data">     
        @csrf
        @method('put')
            <!-- Post Your ad start -->
            <a href="{{ route('user.index_carhire')}}" class="btn btn-primary  mb-2">Back</a>
            <fieldset class="border border-gary p-4 mb-5">
                <h3 style=" text-align: center;">Location Detials</h3>
                <section>
                <div class="row">
                   
                    <div class="col-lg-6">
                        <h6 class="font-weight-bold pt-4 pb-1">Select Your City</h6>
                        <select name="city" data-label="Select City" id="inputGroupSelect" class="form-control">
                            <option value="">Select City</option>
                            @foreach ($cities as $city )
                            <option value="{{ $city->id }}"
                              @if ($city->id == $listing->city_id)
                              selected
                              @endif
                              >{{ $city->city }}</option>
                            @endforeach
                        </select>
                        @error('city')
                          <span class="invalid"  role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                         @enderror
                        
                    </div>
                </div>
                </section>
            </fieldset>

        <fieldset class="border border-gary p-4 mb-5 4" >
          <h4 style=" text-align: center;">Car Hiring Section</h4>
          <section>
          <div class="row">
              
               
                <div class="col-lg-6"> 
                <h6 class="font-weight-bold pt-4 pb-1">Pick Up Date</h6>
                <input name="pickup_date" value="{{$vehicle->pickup_date}}" type="date" class="border w-100 p-2 bg-white text-capitalize" >
                @error('pickup_date') 
                  <span class="invalid" role="alert"> <strong>{{ $message }}</strong> </span> 
                @enderror
            </div>
            <div class="col-lg-6"> 
                <h6 class="font-weight-bold pt-4 pb-1">Return  Date</h6>
                <input name="return_date"  type="date" value="{{$vehicle->return_date}}"  class="border w-100 p-2 bg-white text-capitalize" >
                @error('return_date') 
                  <span class="invalid" role="alert"> <strong>{{ $message }}</strong> </span> 
                @enderror
            </div>
             <div class="col-lg-6">
                <h6 class="font-weight-bold pt-4 pb-1">Hiring Days</h6>
                <input name="rent_days" type="number" value="{{$vehicle->rent_days}}"  class="border w-100 p-2 bg-white text-capitalize" >
                @error('rent_days') 
                 <span class="invalid" role="alert"> <strong>{{ $message }}</strong> </span> 
                @enderror
            </div>
            <div class="col-lg-6"> 
                <h6 class="font-weight-bold pt-4 pb-1">Price Per Date</h6>
                <input name="price_per_day" type="number" value="{{$vehicle->price_per_day}}" class="border w-100 p-2 bg-white text-capitalize" >
                @error('price_per_day') 
                    <span class="invalid" role="alert"> <strong>{{ $message }}</strong> </span> 
               @enderror
            </div>

          </div>
          </section>
      </fieldset>
<!-- Post Your ad start -->
<fieldset class="border border-gary p-4 mb-5">
  <div class="row">

          <div class="col-lg-4"> 
          <h6 class="font-weight-bold pt-4 pb-1">Select Make</h6>
     
          
              <select name="make" class="make form-control">
                <option value="">Choose a Make</option>
                    @foreach($makes as $make)
                        <option value="{{ $make->id }}"
                        @if ($vehicle->carmodel->carmake->id == $make->id)
                        selected
                        @endif
                        >{{ $make->make }}</option>
                    @endforeach
              </select>
                @error('make_id')
                  <span class="invalid"  role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
            <div class="col-lg-4 carmodel"> 
              <h6 class="font-weight-bold pt-4 pb-1">Select Model</h6>        
              <select name="model_id" class="model form-control">
                <option value="0"  disabled="true" selected="true">Choose a model</option>
                @foreach($models as $model)
                    <option value="{{ $model->id }}"
                      @if ($model->id == $vehicle->model_id)
                      selected
                      @endif
                      >{{ $model->model }}</option>
                  
                  @endforeach

              </select>
                @error('model_id')
                <span class="invalid"  role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-lg-4"> 
          <h6 class="font-weight-bold pt-4 pb-1">Year of Build:</h6>
          <input type="number" name="year_of_build" value="{{$vehicle->year_of_build}}" class="border w-100 p-2 bg-white text-capitalize @error('year_of_build') is-invalid @enderror" >
              @error('year_of_build')
                  <span class="invalid"  role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          
          <div class="col-lg-6"> 
          <h6 class="font-weight-bold pt-4 pb-1">Select Vehicle Type</h6>
          <select name="vehicle_type" id="inputGroupSelect" class="form-control">
            <option selected>{{$vehicle->vehicle_type}}</option>   
              <option>Car</option>     
              <option>Bus</option> 
              <option>Motorcycle</option>   
              <option>Van</option>    
          </select>
          @error('vehicle_type')
            <span class="invalid" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Select Condition</h6>
          <select name="condition" id="inputGroupSelect" class="form-control">
            <option selected>{{$vehicle->condition}}</option>       
              <option >Foreign Used</option>     
              <option>Local Used</option>    
          </select>
          @error('condition')
            <span class="invalid" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Mileage:</h6>
          <input type="number" name="mileage" class="border w-100 p-2 bg-white text-capitalize" 
            value="{{$vehicle->mileage}}" placeholder="Mileage go There">
          @error('mileage')
          <span class="invalid" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Select Transmission</h6>
          <select name="transmission"  id="inputGroupSelect" class="form-control">
            <option selected>{{$vehicle->transmission}}</option>         
              <option>Manual</option>     
              <option>Automatic </option>    
          </select>
          @error('transmission')
          <span class="invalid" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Select Fuel Type</h6>
          <select name="fuel_type" id="inputGroupSelect" class="form-control">
            <option selected>{{$vehicle->fuel_type}}</option>    
              <option>Petrol</option>     
              <option>Diesel</option>    
          </select>
          @error('fuel_type')
                <span class="invalid"  role="alert">
                    <strong>{{ $message }}</strong>
                </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Select Exchange</h6>
          <select name="exchange" id="inputGroupSelect" class="form-control">
            <option selected>{{$vehicle->exchange}}</option>  
            <option>Yes</option>     
            <option>No</option>    
        </select>
          @error('exchange')
            <span class="invalid"  role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Select Body Type</h6>
          <select name="body_type" id="inputGroupSelect" class="form-control">
            <option selected>{{$vehicle->body_type}}</option>  
              <option>saloon</option>     
              <option>Suv</option>    
              <option>convertible</option>    
              <option>coupe</option> 
              <option>hatchback</option>
              <option>pickup</option> 
              <option>stationwagon</option> 
              <option>minivan</option> 
          </select>
          @error('body_type')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Color</h6>
          <select name="color" id="inputGroupSelect" class="form-control">
            <option selected>{{$vehicle->color}}</option>     
            <option>Black</option>     
            <option>white</option>    
            <option>Silver</option>    
            <option>Brown</option>
            <option>Blue</option>
            <option>Red</option>  
            <option>Yellow</option> 
            <option>Purple</option>   
            <option>Green</option>
            <option>Gray</option>  
            <option>Orange</option> 
            <option>Beige</option> 
          </select>
          @error('color')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
          </div>
          <div class="col-lg-12">
          <h6 class="font-weight-bold pt-4 pb-1">Description:</h6>
          <textarea name="description"  class="description ckeditor form-control" name="wysiwyg-editor">
            {{$vehicle->description}}
          </textarea>

          @error('description')
            <span class="invalid"  role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror

          </div>
 
  </div>
</fieldset>
<fieldset class="border border-gary p-4 mb-5">
    <h4 style=" text-align: center;">Upload your cars image</h4>
    <h6 class="font-weight-bold pt-4 pb-1">Kindly follow the below processes</h6>
    <div class="row">
      <div class="space column">
        <div class="card">
          <h3>Front-image</h3>
          @if($vehicle->front_img)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->front_img}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="files"  name="front_img"/>
        </div>
        @error('front_img')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    
      <div class="space column">
        <div class="card">
          <h3>Back-image</h3>
          @if($vehicle->back_img)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->back_img}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="back" name="back_img" />
        </div>
        @error('back_img')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
      
      <div class="space column">
        <div class="card">
          <h3>Right side-image</h3>
          @if($vehicle->right_img)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->right_img}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="right" name="right_img"/>
        </div>
        @error('right_img')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
      
      <div class="space column">
        <div class="card">
          <h3>Left side-image</h3>
          @if($vehicle->left_img)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->left_img}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="files" name="left_img" />
        </div>
        @error('left_img')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
      <div class="space column">
        <div class="card">
          <h3>Interior front</h3>
          @if($vehicle->interiorf_img)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->interiorf_img}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="files" name="interiorf_img"  />
        </div>
        @error('interiorf_img')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
      <div class="space column">
        <div class="card">
          <h3>Interior back</h3>
          @if($vehicle->interiorb_img)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->interiorb_img}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="files" name="interiorb_img"  />
        </div>
        @error('interiorb_img')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>

      <div class="space column">
        <div class="card">
          <h3>Optional 1</h3>
          @if($vehicle->opt_img1)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->opt_img1}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="files" name="opt_img1" />
        </div>
      </div>
      <div class="space column">
        <div class="card">
          <h3>Optional 2</h3>
          @if($vehicle->opt_img2)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->opt_img2}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="files" name="opt_img2" />
        </div>
      </div>
      <div class="space column">
        <div class="card">
          <h3>Optional 3</h3>
          @if($vehicle->opt_img3)
             <img class="mt-2 mb-2" src="/storage/photos/{{ $vehicle->opt_img3}}" style="width: auto; height:120px;" > 
          @endif
          <input type="file" id="files" name="opt_img3" />
        </div>
      </div>
    </div>
  </fieldset>
  <input type="hidden" name="user_id" value="{{ Auth::user()->id}}" >

<button type="submit" class="btn btn-primary d-block mt-2">Update</button>
</form>
    
        </form>
    </div>
</section>
<script src="{{ asset('js/gsdk-bootstrap-wizard.js')}}"></script>
<script src="{{ asset('js/jquery-1.10.2.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/jquery.bootstrap.wizard.js')}}"></script>
<script src="{{ asset('js/wizard.js')}}"></script>  

<script>

  
$(document).ready(function(){
// Prepare the preview for profile picture
    $("#wizard-picture").change(function(){
        readURL(this);
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}


  
  $('.wizard-card').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next',
        'previousSelector': '.btn-previous',

         onInit : function(tab, navigation, index){

           //check number of tabs and fill the entire row
           var $total = navigation.find('li').length;
           $width = 100/$total;

           $display_width = $(document).width();

           console.log($total);

           if($display_width < 600 && $total > 3){
               $width = 50;
           }

           navigation.find('li').css('width',$width + '%');

        },
        
        onTabClick : function(tab, navigation, index){
            // Disable the posibility to click on tabs
            return false;
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;

            var wizard = navigation.closest('.wizard-card');

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $(wizard).find('.btn-next').hide();
                $(wizard).find('.btn-finish').show();
            } else {
                $(wizard).find('.btn-next').show();
                $(wizard).find('.btn-finish').hide();
            }
        }
    });
        
         
  </script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
      $('.ckeditor').ckeditor();
  });
</script>


<style>
  
input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 100px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}
</style>

<script>
function preview() {
    frame.src=URL.createObjectURL(event.target.files[0]);
}

$(document).ready(function(){
    new ConditionalField({
          control: ' .select-field',
          visibility: {
            '2': '.2',
            '4': '.4',
          }
        });

});

$(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
      $("#files").on("change", function(e) {
        var files = e.target.files,
          filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
          var f = files[i]
          var fileReader = new FileReader();
          fileReader.onload = (function(e) {
            var file = e.target;
            $("<span class=\"pip\">" +
              "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
              "<br/><span class=\"remove\">Remove image</span>" +
              "</span>").insertAfter("#files");
            $(".remove").click(function(){
              $(this).parent(".pip").remove();
            });
            
            // Old code here
            /*$("<img></img>", {
              class: "imageThumb",
              src: e.target.result,
              title: file.name + " | Click to remove"
            }).insertAfter("#files").click(function(){$(this).remove();});*/
            
          });
          fileReader.readAsDataURL(f);
        }
      });
    } else {
      alert("Your browser doesn't support to File API")
    }
  });




$(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
      $("#back").on("change", function(e) {
        var files = e.target.files,
          filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
          var f = files[i]
          var fileReader = new FileReader();
          fileReader.onload = (function(e) {
            var file = e.target;
            $("<span class=\"pip\">" +
              "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
              "<br/><span class=\"remove\">Remove image</span>" +
              "</span>").insertAfter("#back");
            $(".remove").click(function(){
              $(this).parent(".pip").remove();
            });
            
            // Old code here
            /*$("<img></img>", {
              class: "imageThumb",
              src: e.target.result,
              title: file.name + " | Click to remove"
            }).insertAfter("#files").click(function(){$(this).remove();});*/
            
          });
          fileReader.readAsDataURL(f);
        }
      });
    } else {
      alert("Your browser doesn't support to File API")
    }
  });
  </script>

  <!-- The script for Car Make -->
  <script>
    $('input.number').keyup(function(event) {
// skip for arrow keys
if(event.which >= 37 && event.which <= 40) return;
// format number
$(this).val(function(index, value) {
  return value
  .replace(/\D/g, "")
  .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
  ;
});
});
  $(document).ready(function(){
$(document).on('change','.make',function(){
  // console.log("hmm its change");
  var make_id=$(this).val();
  // console.log(cat_id);
  var div=$("div.carmodel").parent();
  var option=" ";
  $.ajax({
    type:'get',
    url:'{!!URL::to('user/model')!!}',
    data:{'id':make_id},
    success:function(data){
      
      for(var i=0;i<data.length;i++){
        option+='<option value="'+data[i].id+'" >'+data[i].model+'</option>';
       }
       div.find('.model').html(" ");
       div.find('.model').append(option);
    },
    
    error:function(){    }
  });
});
});
  </script>
  @endsection