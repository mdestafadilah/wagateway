<x-layout-dashboard title="Home">
  
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
               
                @if (session()->has('alert'))
                <x-alert>
                    @slot('type',session('alert')['type'])
                    @slot('msg',session('alert')['msg'])
                </x-alert>
             @endif
             @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <div class="row">
                    {{-- text danger subscription --}}
                     <h5 class="nav-link text-{{Auth::user()->is_expired_subscription ? 'danger' : 'success'}}  mt-1 hide-sidebar-toggle-button">Subscription : {{Auth::user()->expired_subscription}}</h5>
                               
                 
               
                    <div class="col-xl-6">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">contacts</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">All Contacts</span>
                                        <span class="widget-stats-amount">{{ Auth::user()->contacts()->count()}}</span>
    
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-warning">
                                        <i class="material-icons-outlined">message</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Blast Message</span>
    
                                        <span class="widget-stats-info">{{Auth::user()->blasts()->where(['status' => 'success'])->count()}} Success</span>
                                        <span class="widget-stats-info">{{Auth::user()->blasts()->where(['status' => 'failed'])->count()}} Failed</span>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                       </div>
                    </div>
                   
                    {{-- <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">schedule</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Pesan jadwal</span>
    
                                        <span class="widget-stats-info">0 Sukses</span>
                                        <span class="widget-stats-info">0 Gagal</span>
                                        <span class="widget-stats-info">0 Pending</span>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-4">

                                    <h5 class="">List Devices </h5><span class="text-warning text-sm">*You have {{$limit_device}} limit devices</span>
                                </div>
                                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addDevice"><i class="material-icons">add</i>Add </button>
                                <table class="table table-striped">
                                    <thead>
                                        <th>Number</th>
                                        <th>Webhook</th>
                                        <th>Messages Sent</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                       @foreach ($numbers as $number)
                                       <tr>
    
                                        <td>{{$number['body']}}</td>
                                        <td>
                                            <form action="" method="post">
                                                @csrf
                                                <input type="text" id="webhook" class="form-control form-control-solid-bordered" data-id="{{$number['body']}}" name="" value="{{$number['webhook']}}" id="">
                                            </form>
                                        </td>
                                        <td>{{$number['messages_sent']}}</td>
                                        <td><span class="badge badge-{{ $number['status'] == 'Connected' ? 'success' : 'danger'}}">{{$number['status']}}</span></td>
                                        <td>
                                            <div class="d-flex justify-content-center">

                                                <a href="{{route('scan',$number->body)}}" class="btn btn-warning "  style="font-size: 10px;"><i class="material-icons">qr_code</i></a>
                                                <form action="{{route('deleteDevice')}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <input name="deviceId" type="hidden" value="{{$number['id']}}">
                                                    <button type="submit" name="delete" class="btn btn-danger "><i class="material-icons">delete_outline</i></button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                       @endforeach
                                           
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="addDevice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('addDevice')}}" method="POST">
                        @csrf
                        <label for="sender" class="form-label">Number</label>
                        <input type="number" name="sender" class="form-control" id="nomor"  required>
                        <p class="text-small text-danger">*Use Country Code ( without + )</p>
                        <label for="urlwebhook" class="form-label">Link webhook</label>
                        <input type="text" name="urlwebhook" class="form-control" id="urlwebhook">
                        <p class="text-small text-danger">*Optional</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit"  name="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var typingTimer;                //timer identifier
var doneTypingInterval = 1000;
        $('#webhook').keydown(function(){
            clearTimeout(typingTimer);

            typingTimer = setTimeout(function(){
                $.ajax({
           method : 'POST',
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           url : '{{route('setHook')}}',
           data : {
               number : $('#webhook').data('id'),
               webhook : $('#webhook').val()
           },
           dataType : 'json',
           success : (result) => {
           
           },
           error : (err) => {
                console.log(err);
           }
       })
            }, doneTypingInterval);
        })
    </script>

</x-layout-dashboard>