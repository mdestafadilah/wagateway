
                                   
                               <li class="mx-4">
             
                                        <select class="form-control" id="device_idd" name="device_id">
                                           
                                            
                                    
                                            <option value="" >Select Device</option>
                                        
                                           
                                                       
                                            @foreach ($numbers as $device)
                                                {{-- if session has selectedDevice and match = --}}
                                                @if(Session::has('selectedDevice') && Session::get('selectedDevice') == $device->body)
                                                   {{-- make variable selected true --}}
                                                    <option value="{{$device->body}}" selected>{{$device->body}} ({{$device->status}})</option>
                                                @else
                                                    <option value="{{$device->body}}">{{$device->body}} ({{$device->status}})</option>
                                                @endif
                                              
                                            @endforeach
                                        </select>
                                    
                                </li>

<script>
    //  on select device
    $('#device_idd').on('change', function() {
        var device = $(this).val();
      
        // ajax to home.setSessionSelectedDevice
        $.ajax({
            url: "{{route('home.setSessionSelectedDevice')}}",
            type: "POST",
            data: {
                _token: "{{csrf_token()}}",
                device: device
            },
            success: function(data) {
                // reload page
                location.reload();
            }
        });
      
    });
</script>