@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">

                      <span>Dashboard</span>   

                    </div>
                  
                    <div class="card-body">
                       <div class="container">
                        <div class="card float-start mr-2" style="width: 18rem;">
                     
                        <router-link class="px-2" to="/create">
                         <img src="{{url(config('APP_URL').'images/post.png')}}" class="card-img-top" alt="..."></router-link>
                           
                        </div>  

                        <div class="card" style="width: 18rem;">
                        <router-link class="px-2" to="/posts">
                         <img src="{{url(config('APP_URL').'images/default2.jpeg')}}" class="card-img-top" alt="..."></router-link>
                           
                        </div>  
                           
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
