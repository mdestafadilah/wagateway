<x-layout-dashboard title="Rest Api">
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
                <h2 class="my-5">Change Password</h2>
               
                <div class="row">

                     <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                             <div class="col-md-6"> 
                                                <form action="{{route('generateNewApiKey')}}" method="POST">
                                                    @csrf
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">API Key</span>
        
                                                    <input type="text" class="form-control" value="{{Auth::user()->api_key}}" aria-label="Username" aria-describedby="basic-addon1" readonly>
                                                    <button type="submit" name="api_key" class="btn btn-primary">Generate New</button>
                                                </div>
                                                </form>  
                                            </div>
                                            <div class="col-md-6">
                                                <form action="{{route('changeChunk')}}" method="POST">
                                                    @csrf
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">Maximal Blast</span>
        
                                                    <input type="text" name="chunk" class="form-control" value="{{Auth::user()->chunk_blast}}" aria-label="Username" aria-describedby="basic-addon1">
                                                    <button type="submit" name="changechunk" class="btn btn-primary">Save</button>
                                                </div>
                                                </form>
                                             </div>
                                        </div>
                                        <form action="{{route('changePassword')}}" method="POST">
                                        @csrf 
                                        <div class="row m-t-xxl">
                                            <div class="col-md-6">
                                                <label for="settingsCurrentPassword" class="form-label">Current Password</label>
                                                <input type="password" name="current" class="form-control" aria-describedby="settingsCurrentPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                                <div id="settingsCurrentPassword" class="form-text">Never share your password with anyone.</div>
                                            </div>
                                        </div>
                                        <div class="row m-t-xxl">
                                            <div class="col-md-6">
                                                <label for="settingsNewPassword" class="form-label">New Password</label>
                                                <input type="password" name="new" class="form-control" aria-describedby="settingsNewPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                            </div>
                                        </div>
                                        <div class="row m-t-xxl">
                                            <div class="col-md-6">
                                                <label for="settingsConfirmPassword" class="form-label">Confirm Password</label>
                                                <input type="password" name="confirm" class="form-control" aria-describedby="settingsConfirmPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                            </div>
                                        </div>
                                        <div class="row m-t-lg">
                                            <div class="col">
                                               
                                                <button type="submit" class="btn btn-primary m-t-sm">Change Password</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                </div>
            </div>
        </div>
</x-layout-dashboard>