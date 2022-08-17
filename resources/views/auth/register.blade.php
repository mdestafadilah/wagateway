<x-layout-auth>
    @slot('title','Register')
        
    <div class="app app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="index.html">MPWA</a>
            </div>
            @if (session()->has('alert'))
            <x-alert>
                @slot('type',session('alert')['type'])
                @slot('msg',session('alert')['msg'])
            </x-alert>
         @endif
            <p class="auth-description">Please enter your credentials to create an account.<br>Already have an account? <a href="{{route('login')}}">Sign In</a></p>

            <div class="auth-credentials m-b-xxl">
                <form action="" class="" method="post">
                    @csrf
                    
                   
<div class="mb-2">

    <label for="username" class="form-label">Username</label>
    <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{old('username')}}"  id="email" aria-describedby="email" placeholder="Enter username">
    @error('username')
    <div class="form-text text-danger">{{$message}}</div>
    @enderror   
</div>

                      
                  
<div class="mb-2">

    <label for="email" class="form-label">Email</label>
    <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}"  id="email" aria-describedby="email" placeholder="Example@m-pedia.id">
    @error('email')
    <div class="form-text text-danger">{{$message}}</div>
    @enderror   
</div>

    
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" aria-describedby="signUpPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                    @error('password')
                    <div id="emailHelp" class="form-text text-danger">{{$message}}</div>
               @enderror
              
            </div>

            <div class="auth-submit">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </form>
            <div class="divider"></div>
            <div class="auth-alts">
                <a href="#" class="auth-alts-google"></a>
                <a href="#" class="auth-alts-facebook"></a>
                <a href="#" class="auth-alts-twitter"></a>
            </div>
        </div>
    </div>
</x-layout-auth>