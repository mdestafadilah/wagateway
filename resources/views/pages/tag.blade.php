<x-layout-dashboard title="Contacts">
    <div class="app-content">
        <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet">
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
               
               
                <div class="card-header d-flex justify-content-between">
                   
                      <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#selectNomor"><i class="material-icons-outlined">contacts</i>Fetch From Groups WA</button> 
                    <div class="d-flex justify-content-right">
                       
                        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addTag"><i class="material-icons-outlined">add</i>Add</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title">Tags</h5>
                                <!-- <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#selectNomor"><i class="material-icons-outlined">contacts</i>Hapus semua</button>
                                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#selectNomor"><i class="material-icons-outlined">contacts</i>Generate Kontak</button>
                                <div class="d-flex justify-content-right">
                                    <form action="" method="POST">
                                        <button type="submit" name="export" class="btn btn-warning "><i class="material-icons">download</i>Export (xlsx)</button>
                                    </form>
                                    <button type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#importExcel"><i class="material-icons-outlined">upload</i>Import (xlsx)</button>
                                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addNumber"><i class="material-icons-outlined">add</i>Tambah</button>
                                </div> -->
                            </div>
                            <div class="card-body">
                                <table id="datatable1" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="d-flex justify-content-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($tags as $tag)
                                           
                                       <tr>
                                           <td>{{$tag->name}}</td>
                                           <td>
                                               <div class="d-flex justify-content-center">
                                                   <a class="btn btn-success btn-sm mx-3" href="/contact/{{$tag->id}}">View List Numbers</a>
                                                   <form action="{{route('tag.delete')}}" method="POST" onsubmit="return confirm('do you sure want to delete this tag? ( All contacts in this tag also will delete! )')">
                                                    @method('delete')
                                                    @csrf
                                                       <input type="hidden" name="id" value="{{$tag->id}}">
                                                       <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="material-icons">delete_outline</i>Delete</button>
                                                    </form>
                                               </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                      
    
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
    
                </div>
    
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="addTag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('tag.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal select sender --}}
    <div class="modal fade" id="selectNomor" tabindex="-1" aria-labelledby="SelectNomorModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('fetch.groups')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="" class="form-label">Sender ?</label>
                        <select id="tag" name="sender" class="js-states form-control" tabindex="-1" style="display: none; width: 100%" required>
                            @foreach ($senders as $sender)
                              <option value="{{$sender->body}}">{{$sender->body}}</option>
                            @endforeach
                         </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Fetch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  

    <script src="{{asset('js/pages/datatables.js')}}"></script>
    <script src="{{asset('js/pages/select2.js')}}"></script>
    <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
   
</x-layout-dashboard>