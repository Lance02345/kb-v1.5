@extends('layouts.modern-app')
@section('content')
@include('modern._nav')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<section class="section-sm">
    <div class="container py-5">
      <div class="vehicle-sale-hero">
        <h1>Create Vehicle Sale Listing</h1>
        <p>Complete all sections below to publish a high-quality listing faster.</p>
      </div>

      <ul class="vehicle-sale-steps">
        <li data-step-indicator class="active">1. Intro</li>
        <li data-step-indicator>2. Location</li>
        <li data-step-indicator>3. Vehicle Details</li>
        <li data-step-indicator>4. Pricing</li>
        <li data-step-indicator>5. Photos</li>
      </ul>

      <form action="{{ route('user.store_vehiclesale')}}" method="POST" id="step-form-horizontal" class="step-form-horizontal vehicle-sale-form" enctype="multipart/form-data" data-stepper-form>     
        @csrf
           <!-- Post Your ad start -->
           <fieldset data-step-panel class="border border-gary p-4 mb-5 sale-form-section">
            <div class="row">
              <div class="col-lg-12">
                <h2 class="sale-section-title">Post your vehicle for sale</h2>
              </div>
            </div>
           </fieldset>

           <fieldset data-step-panel class="border border-gary p-4 mb-5 sale-form-section">
            <h3 class="sale-section-title">Location Details</h3>
            <section>
            <div class="row">
                
                <div class="col-lg-6">
                  <input type="hidden" name="user_id" value="{{ Auth::user()->id}}" >
                    <h6 class="font-weight-bold pt-4 pb-1">Select Ad Category:</h6>
                    <select name="category" id="inputGroupSelect" class="form-control ">
                        <option value="">Select category</option>
                        <option value="2" selected>VehicleSale</option>
                
                    </select>
                    @error('category')
                    <span class="invalid"  role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                   @enderror
                </div>
                <div class="col-lg-6">
                    <h6 class="font-weight-bold pt-4 pb-1">Select Your City</h6>
                    <select name="city" data-label="Select City" id="inputGroupSelect" class="form-control">
                        <option value="">Select City</option>
                        
                        
                        @foreach ($cities as $city )
                         <option value="{{ $city->id }}" {{(old('city')==$city->id)? 'selected':''}}>
                          {{ $city->city }}</option> 
                    
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
<!-- Post Your ad start -->
<fieldset data-step-panel class="border border-gary p-4 mb-5 sale-form-section">
  <div class="row">

          <div class="col-lg-4"> 
          <h6 class="font-weight-bold pt-4 pb-1">Select Make</h6>
     
          
              <select name="make" class="make form-control">
                <option value="">Choose a Make</option>
    
                  @foreach($makes as $make)
                    <option value="{{ $make->id }}" {{(old('make'))? 'selected':''}}>{{ $make->make }}</option>
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

              </select>
                @error('model_id')
                <span class="invalid"  role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-lg-4"> 
          <h6 class="font-weight-bold pt-4 pb-1">Year of Build:</h6>
          <input type="number" value="{{ old('year_of_build')}}" name="year_of_build" class="border w-100 p-2 text-capitalize @error('year_of_build') is-invalid @enderror" placeholder="1964">
              @error('year_of_build')
                  <span class="invalid"  role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          
          <div class="col-lg-6"> 
          <h6 class="font-weight-bold pt-4 pb-1">Select Vehicle Type</h6>
          <select name="vehicle_type" id="inputGroupSelect" class="form-control">
              <option value="{{ old('vehicle_type')}}" {{(old('vehicle_type'))? 'selected':''}}> {{ old('vehicle_type')}} </option>     
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
              <option value="{{ old('condition')}}" {{(old('condition'))? 'selected':''}}> {{ old('condition')}} </option>     
              <option >Foreign Used</option>     
              <option>Local Used</option> 
              <option>Brand New</option>
          </select>
          @error('condition')
            <span class="invalid" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Mileage:</h6>
          <input type="number" name="mileage" class="border w-100 p-2 text-capitalize" 
            value="{{ old('mileage')}}" placeholder="Mileage go There">
          @error('mileage')
          <span class="invalid" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
          </div>
          <div class="col-lg-6">
          <h6 class="font-weight-bold pt-4 pb-1">Select Transmission</h6>
          <select name="transmission"  id="inputGroupSelect" class="form-control">
            <option value="{{ old('transmission')}}" {{(old('transmission'))? 'selected':''}}> {{ old('transmission')}} </option>   
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
            <option value="{{ old('fuel_type')}}" {{(old('fuel_type'))? 'selected':''}}> {{ old('fuel_type')}} </option> 
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
          <option value="{{ old('exchange')}}" {{(old('exchange'))? 'selected':''}}> {{ old('exchange')}} </option> 
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
            <option value="{{ old('body_type')}}" {{(old('body_type'))? 'selected':''}}> {{ old('body_type')}} </option>  
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
            <option value="{{ old('color')}}" {{(old('color'))? 'selected':''}}> {{ old('color')}} </option>     
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
          <div class="col-lg-6">
            <h6 class="font-weight-bold pt-4 pb-1">Select Duty Type</h6>
          <select name="duty_type" id="inputGroupSelect" class="form-control">
            <option value="{{ old('duty_type')}}" {{(old('duty_type'))? 'selected':''}}> {{ old('duty_type')}} </option>        
              <option>Paid</option>     
              <option>unpaid</option>    
          </select>
          @error('duty_type')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
          </div>
          <div class="col-lg-6">
            <h6 class="font-weight-bold pt-4 pb-1">Select Interior Type</h6>
          <select name="interior_type" id="inputGroupSelect" class="form-control">
            <option value="{{ old('interior_type')}}" {{(old('interior_type'))? 'selected':''}}> {{ old('interior_type')}} </option>          
              <option>leather</option>     
              <option>cloth</option>     
          </select>
          @error('interior_type')
              <span class="invalid"  role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
          </div>
          <div class="col-lg-6">
            <h6 class="font-weight-bold pt-4 pb-1">Engine size</h6>
          <select name="engine_size" id="inputGroupSelect" class="form-control">
            <option value="{{ old('engine_size')}}" {{(old('engine_size'))? 'selected':''}}> {{ old('engine_size')}} </option>    
            <option>1.0L</option>     
            <option>1.2L</option> 
            <option>1.4L</option> 
            <option>1.5L</option> 
            <option>1.6L</option> 
            <option>1.7L</option> 
            <option>1.8L</option> 
            <option>2L</option> 
            <option>2.2L</option>
            <option>2.3L</option> 
            <option>2.5L</option>  
            <option>2.6L</option> 
            <option>2.8L</option> 
            <option>3L</option> 
            <option>3.2L</option>
            <option>3.3L</option>  
            <option>3.5L</option> 
            <option>3.7L</option>
            <option>3.8L</option> 
            <option>3.9L</option> 
            <option>4L</option>  
            <option>4.2L</option> 
            <option>4.3L</option> 
            <option>4.4L</option> 
            <option>4.8L</option> 
            <option>4.9l</option> 
            <option>5L</option> 
            <option>5.2L</option> 
            <option>5.7L</option> 
            <option>5.8L</option> 
            <option>5.9L</option> 
            <option>6L</option> 
            <option>6.2L</option> 
            <option>6.6L</option> 
            <option>6.9L</option> 
            <option>7L</option> 
            <option>7.9L</option> 

          </select>
          @error('engine_size')
            <span class="invalid"  role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror

          </div>

          <div class="col-lg-12">
          <h6 class="font-weight-bold pt-4 pb-1">Description:</h6>
          <textarea name="description"  class="description ckeditor form-control" name="wysiwyg-editor">
            {{ old('description')}}
          </textarea>

          @error('description')
            <span class="invalid"  role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror

          </div>
 
  </div>
</fieldset>




<fieldset data-step-panel class="border border-gary p-4 mb-5 sale-form-section">
  <div class="row">
      <div class="col-lg-12">
          <h3 class="sale-section-title">Listing Pricing Information</h3>
      </div>

<div class="col-lg-6">
    <h6 class="font-weight-bold pt-4 pb-1">Price (in Ksh):</h6>
    <input name="price" id="priceInput" value="{{ old('price')}}" type="text" class="border w-100 p-2 text-capitalize">
    @error('price')
        <span class="invalid" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
                    
                    
<script>
    // Add event listener to format price input with commas
    document.getElementById('priceInput').addEventListener('input', function(e) {
        let price = e.target.value.replace(/,/g, ''); // Remove existing commas
        price = parseFloat(price.replace(/[^\d.-]/g, '')); // Remove non-numeric characters
        e.target.value = price.toLocaleString('en-US'); // Format with commas
    });
</script>

    <div class="col-lg-6"> 
      <h6 class="font-weight-bold pt-4 pb-1">Negotiable</h6>
      <input type="checkbox" value="Negotiable" >
      
    </div>
     
  </div>

</fieldset>
<fieldset data-step-panel class="border border-gary p-4 mb-5 sale-form-section">
  <h4 class="sale-section-title">Upload your vehicle images</h4>
  <h6 class="font-weight-bold pt-4 pb-1">First image must be the front of the vehicle, the rest can come in any order.</h6>
  <div class="row">
    <div class="space column">
      <div class="card">
        <h3>Front-image</h3>
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
        <input type="file" id="right_img" name="right_img"/>
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
        <input type="file" id="left_img" name="left_img" />
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
        <input type="file" id="interior_front" name="interiorf_img"  />
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
        <input type="file" id="interior_back" name="interiorb_img"  />
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
        <input type="file" id="optional_1" name="opt_img1" />
      </div>
    </div>
    <div class="space column">
      <div class="card">
        <h3>Optional 2</h3>
        <input type="file" id="optional_2" name="opt_img2" />
      </div>
    </div>
    <div class="space column">
      <div class="card">
        <h3>Optional 3</h3>
        <input type="file" id="optional_3" name="opt_img3" />
      </div>
    </div>
  </div>
</fieldset>
@include('user.partials.listing-stepper-controls', ['submitText' => 'Continue to Package Selection'])
</form>

    </div>
</section>
<script src="{{ asset('js/gsdk-bootstrap-wizard.js')}}"></script>
<script src="{{ asset('js/jquery-1.10.2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
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
<script src="//cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
      $('.ckeditor').ckeditor();
  });
</script>


<style>
body .vehicle-sale-hero h1,
body .sale-section-title,
body .vehicle-sale-steps li,
body h6,
body h4 {
  color: #fff;
}

body .vehicle-sale-hero p,
body .vehicle-sale-steps {
  color: #cbd5e1;
}

body .sale-form-section {
  border-color: #1f2937 !important;
  border-radius: 16px;
  background: #111827;
}

body .sale-form-section .form-control,
body .sale-form-section input,
body .sale-form-section textarea,
body .sale-form-section select {
  border: 1px solid #334155 !important;
  border-radius: 10px !important;
  background: #0f172a !important;
  color: #fff !important;
  -webkit-text-fill-color: #fff;
}

body .sale-form-section .form-control:focus,
body .sale-form-section input:focus,
body .sale-form-section textarea:focus,
body .sale-form-section select:focus {
  border-color: #fbbf24 !important;
  box-shadow: 0 0 0 0.15rem rgba(251, 191, 36, 0.2) !important;
}

body .sale-form-section input::placeholder,
body .sale-form-section textarea::placeholder {
  color: #94a3b8 !important;
  opacity: 1;
}

body .sale-form-section input:-webkit-autofill,
body .sale-form-section input:-webkit-autofill:hover,
body .sale-form-section input:-webkit-autofill:focus,
body .sale-form-section textarea:-webkit-autofill,
body .sale-form-section textarea:-webkit-autofill:hover,
body .sale-form-section textarea:-webkit-autofill:focus,
body .sale-form-section select:-webkit-autofill,
body .sale-form-section select:-webkit-autofill:hover,
body .sale-form-section select:-webkit-autofill:focus {
  -webkit-text-fill-color: #fff !important;
  box-shadow: 0 0 0 1000px #0f172a inset !important;
  transition: background-color 9999s ease-in-out 0s;
}

body .sale-form-section .card,
body .sale-form-section .package-content {
  border: 1px solid #334155 !important;
  border-radius: 12px !important;
  background: #0f172a !important;
  color: #e2e8f0 !important;
}

body .sale-form-section .card h3,
body .sale-form-section .package-content h2,
body .sale-form-section .package-content h4 {
  color: #e2e8f0 !important;
}

body .sale-form-section input[type="file"] {
  width: 100%;
  border: 1px solid #334155 !important;
  border-radius: 10px !important;
  background: #0b1225 !important;
  color: #e2e8f0 !important;
  padding: 8px 10px !important;
}

body .sale-form-section input[type="file"]::file-selector-button {
  border: 0;
  border-radius: 8px;
  background: #fcd34d;
  color: #0f172a;
  font-weight: 700;
  margin-right: 10px;
  padding: 6px 10px;
}

body .cke {
  border: 1px solid #334155 !important;
  border-radius: 10px !important;
  overflow: hidden;
}

body .cke_top,
body .cke_bottom {
  background: #0f172a !important;
  border-color: #334155 !important;
}

body .cke_contents {
  background: #ffffff !important;
}

body .invalid strong {
  color: #fca5a5;
}

body .btn-sale-submit {
  border: 0;
  border-radius: 10px;
  background: #fcd34d;
  color: #0f172a;
  font-weight: 700;
}

body .btn-sale-submit:hover {
  background: #fbbf24;
}
  
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
<script>
  $(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
      $("#right_img").on("change", function(e) {
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
              "</span>").insertAfter("#right_img");
            $(".remove").click(function(){
              $(this).parent(".pip").remove();
            });
          });
          fileReader.readAsDataURL(f);
        }
      });
    } else {
      alert("Your browser doesn't support to File API")
    }
  });
  </script>

<script>
$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#left_img").on("change", function(e) {
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
            "</span>").insertAfter("#left_img");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
</script>
<script>
  $(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
      $("#interior_front").on("change", function(e) {
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
              "</span>").insertAfter("#interior_front");
            $(".remove").click(function(){
              $(this).parent(".pip").remove();
            });
          });
          fileReader.readAsDataURL(f);
        }
      });
    } else {
      alert("Your browser doesn't support to File API")
    }
  });
  </script>
  <script>
    $(document).ready(function() {
      if (window.File && window.FileList && window.FileReader) {
        $("#interior_back").on("change", function(e) {
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
                "</span>").insertAfter("#interior_back");
              $(".remove").click(function(){
                $(this).parent(".pip").remove();
              });
            });
            fileReader.readAsDataURL(f);
          }
        });
      } else {
        alert("Your browser doesn't support to File API")
      }
    });
    </script>

<script>
  $(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
      $("#optional_1").on("change", function(e) {
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
              "</span>").insertAfter("#optional_1");
            $(".remove").click(function(){
              $(this).parent(".pip").remove();
            });
          });
          fileReader.readAsDataURL(f);
        }
      });
    } else {
      alert("Your browser doesn't support to File API")
    }
  });
  </script>
  <script>
    $(document).ready(function() {
      if (window.File && window.FileList && window.FileReader) {
        $("#optional_2").on("change", function(e) {
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
                "</span>").insertAfter("#optional_2");
              $(".remove").click(function(){
                $(this).parent(".pip").remove();
              });
            });
            fileReader.readAsDataURL(f);
          }
        });
      } else {
        alert("Your browser doesn't support to File API")
      }
    });
    </script>
    <script>
      $(document).ready(function() {
        if (window.File && window.FileList && window.FileReader) {
          $("#optional_3").on("change", function(e) {
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
                  "</span>").insertAfter("#optional_3");
                $(".remove").click(function(){
                  $(this).parent(".pip").remove();
                });
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
  @include('user.partials.listing-stepper-script')
  @endsection
