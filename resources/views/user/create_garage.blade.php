@extends('layouts.kingsbridge')
@section('content')

<section class="section-sm">
    <div class="container">
    <form action="{{ route('user.garages') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col-lg-6"> 
          <h6 class="font-weight-bold pt-4 pb-1">Garage Title:</h6>
          <input type="text" value="{{ old('garage_title')}}" name="garage_title" class="border w-100 p-2 bg-white text-capitalize @error('year_of_build') is-invalid @enderror" placeholder="Garage Title">
              @error('garage_title')
                  <span class="invalid"  role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="col-lg-6"> 
          <h6 class="font-weight-bold pt-4 pb-1">Garage Location:</h6>
          <input type="text" value="{{ old('garage_location')}}" name="garage_location" class="border w-100 p-2 bg-white text-capitalize @error('year_of_build') is-invalid @enderror" placeholder="Garage Location">
              @error('garage_location')
                  <span class="invalid"  role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="col-lg-12">
          <h6 class="font-weight-bold pt-4 pb-1">Garage Description:</h6>
          <textarea name="garage_description"  class="description ckeditor form-control" name="wysiwyg-editor">
            {{ old('garage_description')}}
          </textarea>

          @error('garage_description')
            <span class="invalid"  role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror

          </div>
    <fieldset class="border border-gary p-4 mb-5">
  <h4 style=" text-align: center;">Upload Photos to showcase your work.</h4>
  <h6 class="font-weight-bold pt-4 pb-1">Images can come in any order. Upload atleast three photos</h6>
  <div class="row">
    <div class="space column">
      <div class="card">
        <h3>First-image</h3>
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
        <h3>Second-image</h3>
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
        <h3>Third-image</h3>
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
        <h3>Optional 1</h3>
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
        <h3>Optional 2</h3>
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
        <h3>Optional 3</h3>
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
        <h3>Optional 4</h3>
        <input type="file" id="optional_1" name="opt_img1" />
      </div>
    </div>
    <div class="space column">
      <div class="card">
        <h3>Optional 5</h3>
        <input type="file" id="optional_2" name="opt_img2" />
      </div>
    </div>
    <div class="space column">
      <div class="card">
        <h3>Optional 6</h3>
        <input type="file" id="optional_3" name="opt_img3" />
      </div>
    </div>
  </div>
</fieldset>
<button type="submit" class="btn btn-primary d-block mt-2">Post Your Garage</button>

</form>   

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
<script src="//cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
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




  </script>


  @endsection