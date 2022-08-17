
<x-layout-dashboard title="Blast">

   
  <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet">

<script src="{{asset('js/pages/datatables.js')}}"></script>
<script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>
    <div class="app-content">
        @if (session()->has('alert'))
        <x-alert>
            @slot('type',session('alert')['type'])
            @slot('msg',session('alert')['msg'])
        </x-alert>
     @endif
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                    <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet">
                    <div class="card">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-header">
                                    <h3 class="card-title">Blast</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(!Session::has('selectedDevice'))
                            {{-- please select deviec --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Please select device first</strong>
                                    </div>
                                </div>
                            </div>
                            @else
                            {{-- title, form campaign  --}}
                           {{-- make form sender,tag  --}}
                            <form  id="form" method="POST">
                                @csrf
                                {{-- make 2 form flex --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                    <label for="name">Campaign Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Campaign 1">
                                </div>
                                    </div>
                                    <div class="col-md-6">
                                         <div class="form-group">
                                    <label for="tag">Sender</label>
                                    <input type="text" class="form-control" value="{{Session::get('selectedDevice')}}" id="sender" name="sender" placeholder="Sender" readonly>
                                </div>
                                    </div>
                               
                               <div class="tagsOption">
                    <label for="inputEmail4" class="form-label">Phone Book</label>
                    <select name="tag" id="tag" class="form-control" style="width: 100%; height:200px;">
                      @foreach ($tags as $tag)
                          
                      <option value="{{$tag->id}}">{{$tag->name}}</option>
                      @endforeach
                       
                    </select>
                </div>
                {{-- time form, now or schedule --}}
                <div class="d-flex justify-content-rounded">

    <div class="col ">

        <label for="delay" class="form-label">Delay</label>
        <input type="number" id="delay" min="1" max="60" name="delay" class="form-control"  required>
    </div>
    <div class="col mx-2">
        <label for="tipe" class="form-label">Type</label>
        <select name="tipe" id="tipe" class="form-control" style="width: 100%; height:200px;">
           <option value="immediately">Immediately</option>
           <option value="schedule">Schedule</option>
             
          </select>
    </div>
    <div class="col d-none" id="datetime">

        <label for="datetime" class="form-label">Date Time</label>
        <input type="datetime-local" id="datetime2"  name="datetime" class="form-control">
    </div>
    
</div>



  <label for="type" class="form-label">Type Message</label>
                    <select name="type" id="type" class="js-states form-control" tabindex="-1" required>
                      <option value=""   selected >Select One</option>
                        <option value="text">Text Message</option>
                        <option value="image">Image Message</option>
                        <option value="button">Button Message</option>
                        <option value="template">Template Message</option>
                        <option value="list">List Message</option>
                       
                     </select>
                     <div class="ajaxplace mt-5"></div>

                               {{-- button start --}}
                                <div class="row">
                                    <div class="col-md-12 mt-5">
                                        <button id="startBlast" type="submit" class="btn btn-success">Start</button>
                                    </div>
                                </div>

                            </form>
                            @endif
                           
                        </div>
                    </div>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
    
    
</x-layout-dashboard>
<script src="{{asset('js/autoreply.js')}}"></script>
 
<script src="{{asset('js/pages/select2.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>

    // oncange, if tipe schedule datetime show
    $('#tipe').on('change', function() {
        if (this.value == 'schedule') {
            $('#datetime').removeClass('d-none');
        } else {
            $('#datetime').addClass('d-none');
        }
    });
//    validation on click start blast
$('#startBlast').click(function(e){
    e.preventDefault();

    var name = $('#name').val();
    var tag = $('#tag').val();
    var delay = $('#delay').val();
    var tipe = $('#tipe').val();
    var datetime = $('#datetime2').val();

    // name required
    if(name == ''){
        alert('Campaign Name Required');
        return false;
    }
    //delay required
    if(delay == ''){
        alert('Delay is required');
        return false;
    }
    // if tipe schedule,datetime required and show form datetime
    if(tipe == 'schedule'){
       
        if(datetime == ''){
            alert('Please fill datetime');
            return false;
        }
    }

    

    // type message required
    var type = $('#type').val();
    if(type == ''){
        alert('Please select type message');
        return false;
    }
    // submit
   switch (type) {
    case 'text':
            // id message required
            var id = $('#message').val();
            if(id == ''){
                alert('Please fill  message');
                return false;
            }
        break;
    case 'image':
            // id message required
            let  image = $('#thumbnail').val();
            if(image == ''){
                alert('Please fill  image');
                return false;
            }
            var caption = $('#caption').val();
            if(id == ''){
                alert('Please fill  message');
                return false;
            }
        break;  
    case 'button':
        // message , and button1 required
        var message = $('#message').val();
        if(message == ''){
            alert('Please fill  message');
            return false;
        }
        // is exist form button1
        

        var button1 = $('#button1').val();
       if(button1 == undefined){
            alert('You have to add button at least 1');
            return false;
        }
        if(button1 == ''){
            alert('Please fill  button 1');
            return false;
        }

        break;
    case 'template':
        // message , and button1 required
        var message = $('#message').val();
        if(message == ''){
            alert('Please fill  message');
            return false;
        }
      // delete value input template1
        let template1 = $('#template1').val();
      

        if(template1 == '' || template1 == undefined){
            alert('Please fill  Template 1');
            return false;
        }

        break;
    case 'list':
        // message , and button1 required
        var message = $('#message').val();
        if(message == ''){
            alert('Please fill  message');
            return false;
        }
       // buttonlist,namelist and titlelist required
        var buttonlist = $('#buttonlist').val();
        if(buttonlist == ''){
            alert('Please fill  button list');
            return false;
        }
        var namelist = $('#namelist').val();
        if(namelist == ''){
            alert('Please fill  name list');
            return false;
        }
        var titlelist = $('#titlelist').val();
        if(titlelist == ''){
            alert('Please fill  title list');
            return false;
        }
        // list 1 required and cant undefined
        var list1 = $('#list1').val();
        if(list1 == undefined){
            alert('You have to add list at least 1');
            return false;
        }
        if(list1 == ''){
            alert('Please fill  list 1');
            return false;
        }

        break;
    default:
        break;
   }
    // submit
  
  
   const data = {
    name:name,
    tag:tag,
    sender : $('#sender').val(),
    start_date: tipe == 'schedule' ? $('#datetime2').val() : null,
    type_message: type,
    delay: delay,
    
   }
   // if exist message push to data
    if(type == 'text'){
        data.message = $('#message').val();
    }
    if(type == 'image'){
        data.image = $('#thumbnail').val();
        data.message = $('#caption').val();
    }
    if(type == 'button'){
        data.message = $('#message').val();
        data.button1 = $('#button1').val();
        // if exist button 2 and not empty
        if($('#button2').val() != undefined && $('#button2').val() != ''){
            data.button2 = $('#button2').val();
        }
        if($('#button3').val() != undefined && $('#button3').val() != ''){
            data.button3 = $('#button3').val();
        }
        // if exists image
        if($('#thumbnail').val() != undefined && $('#thumbnail').val() != ''){
            data.image = $('#thumbnail').val();
        }
        // if exists footer
        if($('#footer').val() != undefined && $('#footer').val() != ''){
            data.footer = $('#footer').val();
        }
    }
    if(type == 'template'){
        data.message = $('#message').val();
        data.template1 = $('#template1').val();
        // if exists image
        if($('#thumbnail').val() != undefined && $('#thumbnail').val() != ''){
            data.image = $('#thumbnail').val();
        }
        // if exists footer
        if($('#footer').val() != undefined && $('#footer').val() != ''){
            data.footer = $('#footer').val();
        }
        // if exists and not undefined template 2
        if($('#template2').val() != undefined && $('#template2').val() != ''){
            data.template2 = $('#template2').val();
        }
        // if exists and not undefined template 3
        if($('#template3').val() != undefined && $('#template3').val() != ''){
            data.template3 = $('#template3').val();
        }

    }
    if(type == 'list'){
        data.message = $('#message').val();
        data.buttonlist = $('#buttonlist').val();
        data.namelist = $('#namelist').val();
        data.titlelist = $('#titlelist').val();
        // if exists list1
        if($('#list1').val() != undefined && $('#list1').val() != ''){
            data.list1 = $('#list1').val();
        }
        // if exists list2
        if($('#list2').val() != undefined && $('#list2').val() != ''){
            data.list2 = $('#list2').val();
        }
        // if exists list3
        if($('#list3').val() != undefined && $('#list3').val() != ''){
            data.list3 = $('#list3').val();
        }
        // if exists list4
        if($('#list4').val() != undefined && $('#list4').val() != ''){
            data.list4 = $('#list4').val();
        }
        // if exists list5
        if($('#list5').val() != undefined && $('#list5').val() != ''){
            data.list5 = $('#list5').val();
        }

         
        // if exists image
        if($('#thumbnail').val() != undefined && $('#thumbnail').val() != ''){
            data.image = $('#thumbnail').val();
        }
        // if exists footer
        if($('#footer').val() != undefined && $('#footer').val() != ''){
            data.footer = $('#footer').val();
        }
    }


    // send data to server
    // disable button submitbutton
    $('#startBlast').attr('disabled',true);
    $('#startBlast').html('Sending...');
    

   
     $.ajax({
           method : 'POST',
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           url : '{{route('blast')}}',
           data : data,
           dataType : 'json',
           success : (result) => {
         
           window.location = ''
           },
           error : (err) => {
                console.log(err);
                window.location = '';
           }
       })
})










</script>