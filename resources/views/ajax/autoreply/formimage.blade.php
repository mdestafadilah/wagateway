<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

                   <label class="form-label">Image</label>
                   <div class="input-group">
                     <span class="input-group-btn">
                       <a id="image" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                         <i class="fa fa-picture-o"></i> Choose
                       </a>
                     </span>
                     <input id="thumbnail" class="form-control"  type="text" name="image" readonly>
                   </div>
                    <label for="Caption" class="form-label">Caption</label>
                    <input type="text" name="caption" class="form-control" id="Caption" required>

                    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $('#image').filemanager('file')
</script>
                  