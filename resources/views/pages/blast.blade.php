<style>
    .lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ellipsis div {
  position: absolute;
  top: 33px;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: black;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}

</style>
<x-layout-dashboard title="Blast">

   
  <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">

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
                    
                        <div class="card todo-container">
                            <div class="row">
                                <div class="col-xl-4 col-xxl-3">
                                    <div class="todo-menu">

                                        <h5 class="todo-menu-title">Type</h5>
                                        <ul class="list-unstyled todo-status-filter">
                                            <li><a onclick="textBlast()" class="optionTextBlast"><i class="material-icons-outlined">email</i>Blast Text</a></li>
                                            <li><a onclick="imageBlast()" class="optionImageBlast"><i class="material-icons-outlined">image</i>Blast Image</a></li>
                                            <li><a onclick="buttonBlast()" class="optionButtonBlast"><i class="material-icons-outlined">email</i>Blast Button</a></li>
                                            <li><a onclick="templateBlast()" class="optionTemplateBlast"><i class="material-icons-outlined">email</i>Blast Template</a></li>
                                            <li><a href="{{route('blastHistories')}}" class="bg-secondary"><i class="material-icons-outlined">history</i>Histories</a></li>
                                            <li><a href="{{route('scheduledMessage')}}" class="bg-secondary"><i class="material-icons-outlined">history</i>Blast Scheduled</a></li>
                                        </ul>
                                       
                                    </div>
                                </div>
                                <div class="col-xl-8 col-xxl-9 formBlastWrapper ">
                                    
                                </div>
                           
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
    
    <script>
    let checkboxAll = 0;
    let checkboxTag = 0;
        function textBlast(){
            $('.optionTemplateBlast').removeClass('active')
            $('.optionButtonBlast').removeClass('active')
            $('.optionTextBlast').addClass('active')
            $('.optionImageBlast').removeClass('active')
           getForm('text-message');   
        }
        function imageBlast(){
            $('.optionTemplateBlast').removeClass('active')
            $('.optionButtonBlast').removeClass('active')
            $('.optionTextBlast').removeClass('active')
            $('.optionImageBlast').addClass('active')
           getForm('image-message');   
        }
        function buttonBlast(){
            $('.optionTemplateBlast').removeClass('active')
            $('.optionTextBlast').removeClass('active')
            $('.optionImageBlast').removeClass('active')
            $('.optionButtonBlast').addClass('active')

           getForm('button-message');   
        }
        function templateBlast(){
            
            $('.optionTextBlast').removeClass('active')
            $('.optionImageBlast').removeClass('active')
            $('.optionButtonBlast').removeClass('active')
            $('.optionTemplateBlast').addClass('active')

           getForm('template-message');   
        }

        function getForm(url){
            $.ajax({
                    url : `/blast/${url}`,
                    method : 'GET',
                    dataType : 'html',
                    success : (result) => {
                      
                        $('.formBlastWrapper').addClass('d-flex align-items-center justify-content-center')
                        $('.formBlastWrapper').html(`<div class="lds-ellipsis flex justify-items-center"><div></div><div></div><div></div><div></div></div>`)
                        setTimeout(() => {
                           
                            $('.formBlastWrapper').removeClass('d-flex')
                            $('.formBlastWrapper').html(result)
                        }, 500);
                        
                    },
                    error : (err) => {
                        console.log(err)
                    }
                })
                return; 
        }

      
   


    </script>
</x-layout-dashboard>