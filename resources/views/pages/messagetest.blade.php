
<x-layout-dashboard title="Message Test">

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
                        <div class="page-description page-description-tabbed">
                           

                            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#text" type="button" role="tab" aria-controls="hoaccountme" aria-selected="true">Text</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#image" type="button" role="tab" aria-controls="security" aria-selected="false">Image</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#button" type="button" role="tab" aria-controls="integrations" aria-selected="false">Button</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#template" type="button" role="tab" aria-controls="integrations" aria-selected="false">Template</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="text" role="tabpanel" aria-labelledby="account-tab">
                                <div class="card">
                                    <div class="card-body">
                                       <h5>Text Message</h5>
                                       <div class="example-container">
                                        <div class="example-content">
                                            <form action="{{route('textMessageTest')}}" method="POST" id="formSendMsg">
                                                @csrf
                                                <label for="textmessage" class="form-label">Sender</label>
                                                <select name="sender" id="" class="form-control" style="width: 100%;" required>
                                                    <?php foreach ($numbers as $number) : ?>
                                                        <option value="{{$number->body}}">{{$number->body}}</option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="number" class="form-label">Number ( receiver )</label>
                                                <input type="text" name="number" class="form-control" id="number" required>
                                                <label for="textmessage" class="form-label">Message</label>
                                                <input type="text" name="message" class="form-control" id="textmessage" required>
                                                <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="security-tab">
                                <div class="card">
                                    <div class="card-body">
                                       <h5>Image Message</h5>
                                       <div class="example-container">
                                        <div class="example-content">
                                            <form action="{{route('imageMessageTest')}}" method="POST" id="formSendMsg">
                                                @csrf
                                                <label for="textmessage" class="form-label">Sender</label>
                                                <select name="sender" id="" class="form-control" style="width: 100%;" required>
                                                    <?php foreach ($numbers as $number) : ?>
                                                        <option value="{{$number->body}}">{{$number->body}}</option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="number" class="form-label">Number ( receiver )</label>
                                                <input type="text" name="number" class="form-control " id="number" required>

<div>
    <label class="form-label mt-4">Image</label>
    <div class="input-group ">
      <span class="input-group-btn">
        <a id="imagetest" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
          <i class="fa fa-picture-o"></i> Choose
        </a>
      </span>
      <input id="thumbnail" class="form-control"  type="text" name="image" readonly>
    </div>
</div>
                                               
                                                <label for="textmessage" class="form-label">Caption</label>
                                                <input type="text" name="message" class="form-control" id="textmessage" required>
                                                <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="button" role="tabpanel" aria-labelledby="integrations-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Button Message</h5>
                                        <div class="example-container">
                                         <div class="example-content">
                                             <form action="{{route('buttonMessageTest')}}" method="POST" id="formSendMsg">
                                                 @csrf
                                                 <label for="textmessage" class="form-label">Sender</label>
                                                 <select name="sender" id="" class="form-control" style="width: 100%;" required>
                                                     <?php foreach ($numbers as $number) : ?>
                                                         <option value="{{$number->body}}">{{$number->body}}</option>
                                                     <?php endforeach; ?>
                                                 </select>
                                                 <label for="number" class="form-label">Number ( receiver )</label>
                                                 <input type="text" name="number" class="form-control" id="number" required>
                                                 
                                                 <label for="textmessage" class="form-label">Message</label>
                                                 <input type="text" name="message" class="form-control" id="textmessage" required>
                                                 <label for="footer" class="form-label">Footer message</label>
                                                 <input type="text" name="footer" class="form-control" id="number" required>
                                                 <label for="button1" class="form-label">Button 1</label>
                                                 <input type="text" name="button1" id="button1" class="form-control">
                                                 <label for="button2" class="form-label">Button 2</label>
                                                 <input type="text" name="button2" id="button2" class="form-control">
                                                 <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
                                             </form>
                                         </div>
                                         </div>
                                     </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="template" role="tabpanel" aria-labelledby="integrations-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Template Message</h5>
                                        <div class="example-container">
                                         <div class="example-content">
                                             <form action="{{route('templateMessageTest')}}" method="POST" id="formSendMsg">
                                                 @csrf
                                                 <label for="textmessage" class="form-label">Sender</label>
                                                 <select name="sender" id="" class="form-control" style="width: 100%;" required>
                                                     <?php foreach ($numbers as $number) : ?>
                                                         <option value="{{$number->body}}">{{$number->body}}</option>
                                                     <?php endforeach; ?>
                                                 </select>
                                                 <label for="number" class="form-label">Number ( receiver )</label>
                                                 <input type="text" name="number" class="form-control" id="number" required>
                                                 
                                                 <label for="textmessage" class="form-label">Message</label>
                                                 <input type="text" name="message" class="form-control" id="textmessage" required>
                                                 <label for="footer" class="form-label">Footer message</label>
                                                 <input type="text" name="footer" class="form-control" id="number" required>
                                                 <label for="template1" class="form-label">Template 1</label>
                                                 <input type="text" placeholder="TYPE|Your text here|UrlOrPhoneNumber" name="template1" id="template" class="form-control">
                                                 <label for="template2" class="form-label">Template 2</label>
                                                 <input type="text" placeholder="TYPE|Your text here|UrlOrPhoneNumber" name="template2" id="template2" class="form-control">
                <span class="text-danger">example Button link : <span class="badge badge-secondary">url|Visit me|https://m-pedia.id</span> <br> example Call button : <span class="badge badge-secondary">call|Call me|6282298859671</span>  <br> The type only have two options, call and url!</span>
<br>
                                                 <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
                                             </form>
                                         </div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout-dashboard>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $('#imagetest').filemanager('file')
</script>