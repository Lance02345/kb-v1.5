@extends('layouts.modern-app')
@section('content')
@include('modern._nav')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<section class="section-sm">
	    <div class="container py-5">
        @if($errors->any())
          <div class="mb-4 rounded-xl border border-rose-300/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
            {{ $errors->first('submit') ?: $errors->first() }}
          </div>
          <script>
            alert(@json($errors->first('submit') ?: $errors->first()));
          </script>
        @endif
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
  <p class="text-xs text-slate-400">Allowed formats: JPEG, PNG, WEBP, GIF, SVG, HEIC, HEIF. Maximum 20MB per photo.</p>

  {{-- progress bar --}}
  <div class="d-flex align-items-center gap-2 mb-3">
    <span class="text-xs text-slate-400">Photos added:</span>
    <span id="img-count" class="text-xs font-bold text-amber-400">0 / 9</span>
    <div class="flex-grow-1 rounded" style="height:4px;background:#1e293b;">
      <div id="img-progress-bar" class="rounded" style="height:4px;width:0%;background:#f59e0b;transition:width .3s;"></div>
    </div>
  </div>

  <div id="img-upload-grid" class="row">

    @php
      $imgSlots = [
        ['id' => 'files',          'name' => 'front_img',    'label' => 'Front',          'required' => true],
        ['id' => 'back',           'name' => 'back_img',     'label' => 'Back',            'required' => false],
        ['id' => 'right_img',      'name' => 'right_img',    'label' => 'Right side',      'required' => false],
        ['id' => 'left_img',       'name' => 'left_img',     'label' => 'Left side',       'required' => false],
        ['id' => 'interior_front', 'name' => 'interiorf_img','label' => 'Interior front',  'required' => false],
        ['id' => 'interior_back',  'name' => 'interiorb_img','label' => 'Interior back',   'required' => false],
        ['id' => 'engine_img',     'name' => 'engine_img',   'label' => 'Engine',          'required' => false],
        ['id' => 'optional_1',     'name' => 'opt_img1',     'label' => 'Optional 1',      'required' => false],
        ['id' => 'optional_2',     'name' => 'opt_img2',     'label' => 'Optional 2',      'required' => false],
        ['id' => 'optional_3',     'name' => 'opt_img3',     'label' => 'Optional 3',      'required' => false],
      ];
    @endphp

    @foreach($imgSlots as $slot)
    <div class="col-6 col-md-4 mb-3 img-slot-wrapper" data-slot-index="{{ $loop->index }}">
      <label class="img-upload-slot d-flex flex-column align-items-center justify-content-center rounded border border-secondary p-2 position-relative"
             for="{{ $slot['id'] }}"
             style="cursor:pointer;min-height:110px;background:#0f172a;transition:border-color .2s;">

        {{-- preview --}}
        <img id="preview_{{ $slot['id'] }}"
             src=""
             alt=""
             class="img-slot-preview d-none rounded"
             style="width:100%;height:90px;object-fit:cover;border-radius:6px;">

        {{-- placeholder icon + label --}}
        <div id="placeholder_{{ $slot['id'] }}" class="text-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-slate-500 mx-auto mb-1">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5V19a1 1 0 001 1h16a1 1 0 001-1v-2.5M16 10l-4-4m0 0L8 10m4-4v12"/>
          </svg>
          <span class="d-block text-xs text-slate-400">{{ $slot['label'] }}</span>
          @if($slot['required'])
            <span class="badge badge-warning text-xs" style="font-size:10px;">Required</span>
          @endif
        </div>

        {{-- checkmark shown after selection --}}
        <span id="check_{{ $slot['id'] }}" class="d-none position-absolute" style="top:6px;right:8px;color:#22c55e;font-size:18px;">&#10003;</span>

        <input type="file"
               id="{{ $slot['id'] }}"
               name="{{ $slot['name'] }}"
               accept="image/*"
               {{ $loop->first ? 'multiple' : '' }}
               class="img-slot-input"
               style="position:absolute;opacity:0;width:100%;height:100%;top:0;left:0;cursor:pointer;">
      </label>

      @error($slot['name'])
        <span class="invalid" role="alert"><strong>{{ $message }}</strong></span>
      @enderror
    </div>
    @endforeach

  </div>
</fieldset>

<script>
(function () {
  var inputs = document.querySelectorAll('.img-slot-input');
  var total  = inputs.length;

  function updateProgress() {
    var filled = Array.from(inputs).filter(function(i){ return i.files && i.files.length > 0; }).length;
    document.getElementById('img-count').textContent = filled + ' / ' + total;
    document.getElementById('img-progress-bar').style.width = Math.round((filled / total) * 100) + '%';
  }

  function renderSlot(input, file) {
    var id = input.id;
    var preview = document.getElementById('preview_' + id);
    var holder = document.getElementById('placeholder_' + id);
    var check = document.getElementById('check_' + id);
    var label = input.closest('label');

    if (!preview || !holder || !check || !label) return;

    if (!file) {
      preview.src = '';
      preview.classList.add('d-none');
      holder.classList.remove('d-none');
      check.classList.add('d-none');
      label.style.borderColor = '';
      return;
    }

    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.classList.remove('d-none');
      holder.classList.add('d-none');
      check.classList.remove('d-none');
      label.style.borderColor = '#22c55e';
    };
    reader.readAsDataURL(file);
  }

  function setInputFile(input, file) {
    var transfer = new DataTransfer();
    if (file) {
      transfer.items.add(file);
    }
    input.files = transfer.files;
    renderSlot(input, file || null);
  }

  function distributeFiles(startIndex, files) {
    Array.from(files).forEach(function (file, offset) {
      var target = inputs[startIndex + offset];
      if (!target) return;
      setInputFile(target, file);
    });

    for (var clearIndex = startIndex + files.length; clearIndex < inputs.length; clearIndex++) {
      if (inputs[clearIndex].dataset.autofilled !== '1') continue;
      setInputFile(inputs[clearIndex], null);
      inputs[clearIndex].dataset.autofilled = '0';
    }

    var nextEmpty = Array.from(inputs).slice(startIndex + files.length).find(function (candidate) {
      return !candidate.files || candidate.files.length === 0;
    });

    updateProgress();

    if (nextEmpty) {
      setTimeout(function () {
        nextEmpty.closest('.img-slot-wrapper').scrollIntoView({ behavior: 'smooth', block: 'center' });
      }, 250);
    }
  }

  inputs.forEach(function (input, idx) {
    input.addEventListener('change', function () {
      if (!this.files || !this.files.length) {
        renderSlot(this, null);
        updateProgress();
        return;
      }

      var selectedFiles = Array.from(this.files);

      if (selectedFiles.length > 1) {
        var remainingSlots = total - idx;
        var filesToUse = selectedFiles.slice(0, remainingSlots);

        filesToUse.forEach(function (_, offset) {
          var target = inputs[idx + offset];
          if (target) {
            target.dataset.autofilled = offset === 0 ? '0' : '1';
          }
        });

        distributeFiles(idx, filesToUse);
        return;
      }

      this.dataset.autofilled = '0';
      renderSlot(this, selectedFiles[0]);
      updateProgress();
    });
  });
})();
</script>
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
  <script>
    (function () {
      var form = document.querySelector('form[data-stepper-form]');
      if (!form) return;

      var MAX_FILE_BYTES = 20 * 1024 * 1024; // 20MB each
      var MAX_TOTAL_BYTES = 40 * 1024 * 1024; // 40MB total

      form.addEventListener('submit', function (event) {
        var total = 0;
        var tooLargeFile = null;
        var inputs = form.querySelectorAll('input[type="file"]');

        inputs.forEach(function (input) {
          if (!input.files) return;
          Array.prototype.forEach.call(input.files, function (file) {
            total += file.size || 0;
            if (!tooLargeFile && file.size > MAX_FILE_BYTES) tooLargeFile = file;
          });
        });

        if (tooLargeFile) {
          event.preventDefault();
          alert('"' + tooLargeFile.name + '" is too large. Maximum is 20MB per file.');
          return;
        }

        if (total > MAX_TOTAL_BYTES) {
          event.preventDefault();
          alert('Total selected images are too large. Keep total upload under 40MB.');
        }
      });
    })();
  </script>
  @include('user.partials.listing-stepper-script')
  @endsection
