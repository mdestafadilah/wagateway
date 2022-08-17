<x-layout-dashboard title="Auto Replies">
  
    <div class="app-content">
        <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet">
        <link href="{{asset('css/custom.css')}}" rel="stylesheet">
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
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title">Lists auto respond</h5>
                                <div class="d-flex">

                                    <form action="{{route('deleteAllAutoreply')}}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="material-icons">delete_outline</i>Delete All</button>
                                    </form>
                                    <button type="button" class="btn btn-primary btn-sm mx-4" data-bs-toggle="modal" data-bs-target="#addAutoRespond"><i class="material-icons-outlined">add</i>Add</button>
                                </div>
                                 </div>
                            <div class="card-body">
                                <table id="datatable1" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Device</th>
                                            <th>Keyword</th>
                                           <th>Type</th>
                                            <th>Respond</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($autoreplies as $autoreply)
                                       <tr>
    
                                        <td>{{$autoreply['device']}} </td>
                                        <td>{{$autoreply['keyword']}} </td>
                                        <td>{{$autoreply['type']}}</td>
                                       <td><button class="btn btn-primary" onclick="viewReply({{$autoreply->id}})">View</button></td>
                                        <td>
                                            <form action="" method="POST">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="id" value="{{$autoreply->id}}">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="material-icons">delete_outline</i></button>
                                            </form>

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
<!-- Modal -->
<div class="modal fade" id="addAutoRespond" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="formautoreply">
                    @csrf
                    <label for="device" class="form-label">Device/Sender</label>
                    <select id="device" name="device" class="js-states form-control" tabindex="-1" style="display: none; width: 100%" required>
                       @foreach ($numbers as $number)
                       <option value="{{$number['body']}}">{{$number['body']}}</option>
                       @endforeach
                    </select>
                    <label for="keyword" class="form-label">Keyword</label>
                    <input type="text" name="keyword" class="form-control" id="keyword" required>
                    <label for="type" class="form-label">Type Reply</label>
                    <select name="type" id="type" class="js-states form-control" tabindex="-1" style="display: none; width: 100%" required>
                      <option selected  disabled>Select One</option>
                        <option value="text">Text Message</option>
                        <option value="image">Image Message</option>
                        <option value="button">Button Message</option>
                        <option value="template">Template Message</option>
                       
                     </select>
                     <div class="ajaxplace"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Auto Reply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body showReply">
                 </div>
        </div>
    </div>
</div>
<!--  -->
    <script src="{{asset('js/pages/datatables.js')}}"></script>
    <script src="{{asset('js/pages/select2.js')}}"></script>
    <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
  <script src="{{asset('js/autoreply.js')}}"></script>
</x-layout-dashboard>