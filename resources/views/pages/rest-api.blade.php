<x-layout-dashboard title="Rest Api">
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <h2 class="my-5">Rest API</h2>
               
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Method</th>
                                        <th scope="col">POST</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Type</th>
                                        <th scope="col">JSON</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">RESPONSE</th>
                                        <th scope="col">{  status : boolean , msg : 'text'  }  (JSON)</th>
                                    </tr>
                                </thead>
    
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-description">Rest Api </p>
                                <div class="example-container">
                                    <div class="example-content">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
<button class="nav-link " id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#textMessage" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Text Message</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
<button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#imageMessage" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
    Image message
</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
<button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#buttonMessage" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Button Message </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#documentMessage" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Document Message </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#templateMessage" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Template Message </button>
                                            </li>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#webhook" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Webhook</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade  show" id="textMessage" role=" tabpanel" aria-labelledby="pills-home-tab">
                                               
                                                <pre class="hljs" style="display: block; overflow-x: auto; padding: 0.5em; background-color: rgb(63, 63, 63); color: rgb(220, 220, 220);"><span class="xml"><span class="php"><span class="hljs-meta" style="color: rgb(127, 159, 127);">&lt;?php</span>

                                                    $data = [
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'api_key'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'{{Auth::user()->api_key}}'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'sender'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Sender'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'number'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'receiver'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'message'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Your message'</span>
                                                    ];
                                                    $curl = curl_init();
                                                    
                                                    curl_setopt_array($curl, <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
                                                      CURLOPT_URL =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">{{url('/')}}/send-message</span>,
                                                      CURLOPT_RETURNTRANSFER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
                                                      CURLOPT_ENCODING =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">''</span>,
                                                      CURLOPT_MAXREDIRS =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">10</span>,
                                                      CURLOPT_TIMEOUT =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">0</span>,
                                                      CURLOPT_FOLLOWLOCATION =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
                                                      CURLOPT_HTTP_VERSION =&gt; CURL_HTTP_VERSION_1_1,
                                                      CURLOPT_CUSTOMREQUEST =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'POST'</span>,
                                                      CURLOPT_POSTFIELDS =&gt; json_encode($data),
                                                      CURLOPT_HTTPHEADER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'Content-Type: application/json'</span>
                                                      ),
                                                    ));
                                                    
                                                    $response = curl_exec($curl);
                                                    
                                                    curl_close($curl);
                                                    <span class="hljs-keyword" style="color: rgb(227, 206, 171);">echo</span> $response;
                                                    
                                                    <span class="hljs-meta" style="color: rgb(127, 159, 127);">?&gt;</span></span></span></pre>
    
                                            </div>
                                            <div class="tab-pane fade" id="imageMessage" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                <pre class="hljs" style="display: block; overflow-x: auto; padding: 0.5em; background-color: rgb(63, 63, 63); color: rgb(220, 220, 220);"><span class="xml"><span class="php"><span class="hljs-meta" style="color: rgb(127, 159, 127);">&lt;?php</span>

                                                    $data = [
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'api_key'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'{{Auth::user()->api_key}}'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'sender'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Sender'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'number'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'receiver'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'message'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Your caption'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'url'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Url image, jpg,png,jpeg'</span>
                                                    ];
                                                    $curl = curl_init();
                                                    
                                                    curl_setopt_array($curl, <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
                                                      CURLOPT_URL =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">{{url('/')}}/send-media</span>,
                                                      CURLOPT_RETURNTRANSFER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
                                                      CURLOPT_ENCODING =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">''</span>,
                                                      CURLOPT_MAXREDIRS =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">10</span>,
                                                      CURLOPT_TIMEOUT =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">0</span>,
                                                      CURLOPT_FOLLOWLOCATION =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
                                                      CURLOPT_HTTP_VERSION =&gt; CURL_HTTP_VERSION_1_1,
                                                      CURLOPT_CUSTOMREQUEST =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'POST'</span>,
                                                      CURLOPT_POSTFIELDS =&gt; json_encode($data),
                                                      CURLOPT_HTTPHEADER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'Content-Type: application/json'</span>
                                                      ),
                                                    ));
                                                    
                                                    $response = curl_exec($curl);
                                                    
                                                    curl_close($curl);
                                                    <span class="hljs-keyword" style="color: rgb(227, 206, 171);">echo</span> $response;
                                                    
                                                    <span class="hljs-meta" style="color: rgb(127, 159, 127);">?&gt;</span></span></span></pre>
    
                                           
                                               
    
                                            </div>
                                            <div class="tab-pane fade" id="buttonMessage" role="tabpanel" aria-labelledby="pills-contact-tab">
                                                <pre class="hljs" style="display: block; overflow-x: auto; padding: 0.5em; background-color: rgb(63, 63, 63); color: rgb(220, 220, 220);"><span class="xml"><span class="php"><span class="hljs-meta" style="color: rgb(127, 159, 127);">&lt;?php</span>

                                                    $data = [
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'api_key'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'{{Auth::user()->api_key}}'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'sender'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Sender'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'number'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'receiver'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'message'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Your message'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'footer'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Your footer message'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'button1'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Button 1'</span>,
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'button2'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Button 2'</span>
                                                    ];
                                                    $curl = curl_init();
                                                    
                                                    curl_setopt_array($curl, <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
                                                      CURLOPT_URL =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">{{url('/')}}/send-button</span>,
                                                      CURLOPT_RETURNTRANSFER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
                                                      CURLOPT_ENCODING =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">''</span>,
                                                      CURLOPT_MAXREDIRS =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">10</span>,
                                                      CURLOPT_TIMEOUT =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">0</span>,
                                                      CURLOPT_FOLLOWLOCATION =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
                                                      CURLOPT_HTTP_VERSION =&gt; CURL_HTTP_VERSION_1_1,
                                                      CURLOPT_CUSTOMREQUEST =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'POST'</span>,
                                                      CURLOPT_POSTFIELDS =&gt; json_encode($data),
                                                      CURLOPT_HTTPHEADER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
                                                        <span class="hljs-string" style="color: rgb(204, 147, 147);">'Content-Type: application/json'</span>
                                                      ),
                                                    ));
                                                    
                                                    $response = curl_exec($curl);
                                                    
                                                    curl_close($curl);
                                                    <span class="hljs-keyword" style="color: rgb(227, 206, 171);">echo</span> $response;
                                                    
                                                    <span class="hljs-meta" style="color: rgb(127, 159, 127);">?&gt;</span></span></span></pre>
    
                                           
                                                
                                            </div>
                                            <div class="tab-pane fade" id="documentMessage" role="tabpanel" aria-labelledby="pills-contact-tab">
<pre class="hljs" style="display: block; overflow-x: auto; padding: 0.5em; background-color: rgb(63, 63, 63); color: rgb(220, 220, 220);"><span class="xml"><span class="php"><span class="hljs-meta" style="color: rgb(127, 159, 127);">&lt;?php</span>

    $data = [
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'api_key'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'{{Auth::user()->api_key}}'</span>,
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'sender'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Sender'</span>,
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'number'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'receiver'</span>,
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'url'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Document url (pdf,doc,docx,excel)'</span>
    ];
    $curl = curl_init();
    
    curl_setopt_array($curl, <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
      CURLOPT_URL =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">{{url('/')}}/send-document</span>,
      CURLOPT_RETURNTRANSFER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
      CURLOPT_ENCODING =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">''</span>,
      CURLOPT_MAXREDIRS =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">10</span>,
      CURLOPT_TIMEOUT =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">0</span>,
      CURLOPT_FOLLOWLOCATION =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
      CURLOPT_HTTP_VERSION =&gt; CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'POST'</span>,
      CURLOPT_POSTFIELDS =&gt; json_encode($data),
      CURLOPT_HTTPHEADER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'Content-Type: application/json'</span>
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    <span class="hljs-keyword" style="color: rgb(227, 206, 171);">echo</span> $response;
    
    <span class="hljs-meta" style="color: rgb(127, 159, 127);">?&gt;</span></span></span></pre>
    
                                           
                                               
                                            </div>
                                            <div class="tab-pane fade" id="templateMessage" role="tabpanel" aria-labelledby="pills-contact-tab">
<pre class="hljs" style="display: block; overflow-x: auto; padding: 0.5em; background-color: rgb(63, 63, 63); color: rgb(220, 220, 220);"><span class="xml"><span class="php"><span class="hljs-meta" style="color: rgb(127, 159, 127);">&lt;?php</span>

    $data = [
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'api_key'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'{{Auth::user()->api_key}}'</span>,
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'sender'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Sender'</span>,
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'number'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'receiver'</span>,
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'message'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Your message'</span>,
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'footer'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'Your footer message'</span>,
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'template1'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'type|yourtext|linkOrNumber'</span>
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'template2'</span> =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'type|yourtext|linkOrNumber'</span>
    ];
    $curl = curl_init();
    
    curl_setopt_array($curl, <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
      CURLOPT_URL =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">{{url('/')}}/send-template</span>,
      CURLOPT_RETURNTRANSFER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
      CURLOPT_ENCODING =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">''</span>,
      CURLOPT_MAXREDIRS =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">10</span>,
      CURLOPT_TIMEOUT =&gt; <span class="hljs-number" style="color: rgb(140, 208, 211);">0</span>,
      CURLOPT_FOLLOWLOCATION =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">true</span>,
      CURLOPT_HTTP_VERSION =&gt; CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST =&gt; <span class="hljs-string" style="color: rgb(204, 147, 147);">'POST'</span>,
      CURLOPT_POSTFIELDS =&gt; json_encode($data),
      CURLOPT_HTTPHEADER =&gt; <span class="hljs-keyword" style="color: rgb(227, 206, 171);">array</span>(
        <span class="hljs-string" style="color: rgb(204, 147, 147);">'Content-Type: application/json'</span>
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    <span class="hljs-keyword" style="color: rgb(227, 206, 171);">echo</span> $response;
    
    <span class="hljs-meta" style="color: rgb(127, 159, 127);">?&gt;</span></span></span></pre>
    
                                           
  
                                            </div>
                                            <pre class="tab-pane fade active show" id="webhook" role="tabpanel" aria-labelledby="pills-contact-tab">
                                              <pre class="php" style="font-family:monospace;"><span style="color: #000000; font-weight: bold;">&lt;?php</span> 
&nbsp;
&nbsp;
 <span style="color: #990000;">header</span><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">'content-type: application/json'</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
 <span style="color: #000088;">$data</span> <span style="color: #339933;">=</span> <span style="color: #990000;">json_decode</span><span style="color: #009900;">&#40;</span><span style="color: #990000;">file_get_contents</span><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">'php://input'</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">,</span> <span style="color: #009900; font-weight: bold;">true</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
 <span style="color: #990000;">file_put_contents</span><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">'whatsapp.txt'</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">'['</span> <span style="color: #339933;">.</span> <span style="color: #990000;">date</span><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">'Y-m-d H:i:s'</span><span style="color: #009900;">&#41;</span> <span style="color: #339933;">.</span> <span style="color: #0000ff;">&quot;]<span style="color: #000099; font-weight: bold;">\n</span>&quot;</span> <span style="color: #339933;">.</span> <span style="color: #990000;">json_encode</span><span style="color: #009900;">&#40;</span><span style="color: #000088;">$data</span><span style="color: #009900;">&#41;</span> <span style="color: #339933;">.</span> <span style="color: #0000ff;">&quot;<span style="color: #000099; font-weight: bold;">\n</span><span style="color: #000099; font-weight: bold;">\n</span>&quot;</span><span style="color: #339933;">,</span> FILE_APPEND<span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>                                               
 <span style="color: #000088;">$message</span> <span style="color: #339933;">=</span> <span style="color: #990000;">strt¸olower</span><span style="color: #009900;">&#40;</span><span style="color: #000088;">$data</span><span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'message'</span><span style="color: #009900;">&#93;</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
 <span style="color: #000088;">$from</span> <span style="color: #339933;">=</span> <span style="color: #990000;">strt¸olower</span><span style="color: #009900;">&#40;</span><span style="color: #000088;">$data</span><span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'from'</span><span style="color: #009900;">&#93;</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
 <span style="color: #000088;">$respon</span> <span style="color: #339933;">=</span> <span style="color: #009900; font-weight: bold;">false</span><span style="color: #339933;">;</span>
&nbsp;
 <span style="color: #666666; font-style: italic;">// auto respond text   </span>
 <span style="color: #000000; font-weight: bold;">function</span> sayHello<span style="color: #009900;">&#40;</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#123;</span>    
 <span style="color: #b1b100;">return</span> <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">&quot;text&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'Halloooo!'</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">;</span>
             <span style="color: #009900;">&#125;</span>
&nbsp;
 <span style="color: #666666; font-style: italic;">// auto respond gambaar            </span>
<span style="color: #000000; font-weight: bold;">function</span> gambar<span style="color: #009900;">&#40;</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#123;</span>
 <span style="color: #b1b100;">return</span> <span style="color: #009900;">&#91;</span>
     <span style="color: #0000ff;">'image'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'url'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'https://seeklogo.com/images/W/whatsapp-logo-A5A7F17DC1-seeklogo.com.png'</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span>
     <span style="color: #0000ff;">'caption'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'Logo whatsapp!'</span>
 <span style="color: #009900;">&#93;</span><span style="color: #339933;">;</span>   
<span style="color: #009900;">&#125;</span>
&nbsp;
<span style="color: #666666; font-style: italic;">//auto respond button</span>
 <span style="color: #000000; font-weight: bold;">function</span> button<span style="color: #009900;">&#40;</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#123;</span>
     <span style="color: #000088;">$buttons</span> <span style="color: #339933;">=</span> <span style="color: #009900;">&#91;</span>
         <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'buttonId'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'id1'</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">'buttonText'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'displayText'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'BUTTON 1'</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">'type'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #cc66cc;">1</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span> <span style="color: #666666; font-style: italic;">// button 1 // </span>
         <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'buttonId'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'id2'</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">'buttonText'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'displayText'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'BUTTON 2'</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">'type'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #cc66cc;">1</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span> <span style="color: #666666; font-style: italic;">// button 2</span>
         <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'buttonId'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'id3'</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">'buttonText'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">'displayText'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'BUTTON 3'</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">'type'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #cc66cc;">1</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span> <span style="color: #666666; font-style: italic;">// button 3</span>
     <span style="color: #009900;">&#93;</span><span style="color: #339933;">;</span>
     <span style="color: #000088;">$buttonMessage</span> <span style="color: #339933;">=</span> <span style="color: #009900;">&#91;</span>
         <span style="color: #0000ff;">'text'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'HOLA, INI ADALAH PESAN BUTTON'</span><span style="color: #339933;">,</span> 
         <span style="color: #0000ff;">'footer'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">'ini pesan footer'</span><span style="color: #339933;">,</span> 
         <span style="color: #0000ff;">'buttons'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #000088;">$buttons</span><span style="color: #339933;">,</span>
         <span style="color: #0000ff;">'headerType'</span> <span style="color: #339933;">=&gt;</span> <span style="color: #cc66cc;">1</span> 
     <span style="color: #009900;">&#93;</span><span style="color: #339933;">;</span>
     <span style="color: #b1b100;">return</span> <span style="color: #000088;">$buttonMessage</span><span style="color: #339933;">;</span>
 <span style="color: #009900;">&#125;</span>
&nbsp;
 <span style="color: #666666; font-style: italic;">// auto respon lists</span>
<span style="color: #000000; font-weight: bold;">function</span> lists<span style="color: #009900;">&#40;</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#123;</span>
 <span style="color: #000088;">$sections</span> <span style="color: #339933;">=</span> <span style="color: #009900;">&#91;</span>
        <span style="color: #009900;">&#91;</span> 
        	<span style="color: #0000ff;">&quot;title&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">&quot;This is List menu&quot;</span><span style="color: #339933;">,</span>
        	<span style="color: #0000ff;">&quot;rows&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #009900;">&#91;</span>
	        <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">&quot;title&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">&quot;List 1&quot;</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">&quot;description&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">&quot;this is list one&quot;</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span>
	        <span style="color: #009900;">&#91;</span><span style="color: #0000ff;">&quot;title&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">&quot;List 2&quot;</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">&quot;description&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">&quot;this is list two&quot;</span><span style="color: #009900;">&#93;</span><span style="color: #339933;">,</span>
    	<span style="color: #009900;">&#93;</span> 
    <span style="color: #009900;">&#93;</span>
<span style="color: #009900;">&#93;</span><span style="color: #339933;">;</span>
&nbsp;
 <span style="color: #000088;">$listMessage</span> <span style="color: #339933;">=</span> <span style="color: #009900;">&#91;</span>
  <span style="color: #0000ff;">&quot;text&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">&quot;This is a list&quot;</span><span style="color: #339933;">,</span>
  <span style="color: #0000ff;">&quot;title&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">&quot;Title Chat&quot;</span><span style="color: #339933;">,</span>
  <span style="color: #0000ff;">&quot;buttonText&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #0000ff;">&quot;Select what will you do?&quot;</span><span style="color: #339933;">,</span>
  <span style="color: #0000ff;">&quot;sections&quot;</span> <span style="color: #339933;">=&gt;</span> <span style="color: #000088;">$sections</span>
 <span style="color: #009900;">&#93;</span><span style="color: #339933;">;</span>
&nbsp;
 <span style="color: #b1b100;">return</span> <span style="color: #000088;">$listMessage</span><span style="color: #339933;">;</span>  
 <span style="color: #009900;">&#125;</span>
&nbsp;
&nbsp;
 <span style="color: #b1b100;">if</span><span style="color: #009900;">&#40;</span><span style="color: #000088;">$message</span> <span style="color: #339933;">===</span> <span style="color: #0000ff;">'hai'</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#123;</span>
     <span style="color: #000088;">$respon</span> <span style="color: #339933;">=</span> sayHello<span style="color: #009900;">&#40;</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
 <span style="color: #009900;">&#125;</span> <span style="color: #b1b100;">else</span> <span style="color: #b1b100;">if</span><span style="color: #009900;">&#40;</span><span style="color: #000088;">$message</span> <span style="color: #339933;">===</span> <span style="color: #0000ff;">'gambar'</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#123;</span>
     <span style="color: #000088;">$respon</span> <span style="color: #339933;">=</span> gambar<span style="color: #009900;">&#40;</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
 <span style="color: #009900;">&#125;</span> <span style="color: #b1b100;">else</span> <span style="color: #b1b100;">if</span><span style="color: #009900;">&#40;</span><span style="color: #000088;">$message</span> <span style="color: #339933;">===</span> <span style="color: #0000ff;">'tes button'</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#123;</span>
     <span style="color: #000088;">$respon</span> <span style="color: #339933;">=</span> button<span style="color: #009900;">&#40;</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
 <span style="color: #009900;">&#125;</span> <span style="color: #b1b100;">else</span> <span style="color: #b1b100;">if</span><span style="color: #009900;">&#40;</span><span style="color: #000088;">$message</span> <span style="color: #339933;">===</span> <span style="color: #0000ff;">'lists msg'</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#123;</span>
     <span style="color: #000088;">$respon</span> <span style="color: #339933;">=</span> lists<span style="color: #009900;">&#40;</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
 <span style="color: #009900;">&#125;</span>
 <span style="color: #b1b100;">echo</span> <span style="color: #990000;">json_encode</span><span style="color: #009900;">&#40;</span><span style="color: #000088;">$respon</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span>
<span style="color: #000000; font-weight: bold;">?&gt;</span></pre>   
                                            </pre>
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