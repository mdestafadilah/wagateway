
<label for="message" class="form-label">Message</label>
<input type="text" name="message" class="form-control" id="message" required>
<label for="footer" class="form-label">Footer message *optional</label>
<input type="text" name="footer" class="form-control" id="footer" >
 <label class="form-label">Image <span class="text-sm text-warbubg">*OPTIONAL</span></label>
                   <div class="input-group">
                     <span class="input-group-btn">
                       <a id="image" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                         <i class="fa fa-picture-o"></i> Choose
                       </a>
                     </span>
                     <input id="thumbnail" class="form-control"  type="text" name="image" readonly>
                   </div>
<button type="button" id="addbutton" class="btn btn-primary btn-sm">Add Button</button>
<button type="button" id="reduceButton" class="btn btn-danger btn-sm">Reduce Button</button>
<div class="button-area">

</div>



  <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    // add button when click add button maximal 3 button
    $(document).ready(function() {
        $('#image').filemanager('file')
        var max_fields = 3; //maximum input boxes allowed
        var wrapper = $(".button-area"); //Fields wrapper
        var add_button = $("#addbutton"); //Add button ID
        var x = 0; //initlal text box count
        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="form-group"><label for="button' + x + '" class="form-label">Button ' + x + '</label><input type="text" name="button' + x + '" class="form-control" id="button' + x + '" required></div>'); //add input box
            }
        });
        // reduce button when click
        $(document).on('click', '#reduceButton', function(e) {
            e.preventDefault();
           if(x > 0){

            $('.form-group:last').remove();
            x--;
           }
        });
       
    });


</script>