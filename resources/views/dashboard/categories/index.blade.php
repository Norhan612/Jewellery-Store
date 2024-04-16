@extends('layouts.dashboard')

@section('title','Categories')

@section('breadcrumb')
  @parent 
  <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
 
<!-- Main content -->
<div class="page-body">
    <div class="container">
        
        <x-alert type="success" />
        <x-alert type="info" />

        <div class="row justify-content-center">

           
            <div class="col-xl-12 col-md-12">
                <div class="card table-card">
                    <div class="card-header text-center fw-bold text-white fs-2">
                      Categories
                    </div>
          
                        <div class="row mt-4">
                            <div class="col-md-2  float-start">
                                <a href="{{ route('categories.create') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: #00a8bd;transform: ;msFilter:;">
                                        <path d="M4.5 8.552c0 1.995 1.505 3.5 3.5 3.5s3.5-1.505 3.5-3.5-1.505-3.5-3.5-3.5-3.5 1.505-3.5 3.5zM19 8h-2v3h-3v2h3v3h2v-3h3v-2h-3zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1h2z"></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="col-md-10  float-end">
                                <div class="form-group">
                                    <form action="{{ URL::current() }}" method="GET" class="d-flex justify-content-between mb-4">
                                    
                                        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
                                        <select name="status" class="form-control mx-2">
                                            <option value="">All</option>
                                            <option value="active" @selected(request('status') == 'active')>Active</option>
                                            <option value="inactive" @selected(request('status') == 'inactive')>Inactive</option>
                                        </select>
                            
                                        <button type="submit" class="btn btn-dark rounded-5 mx-2">filter</button>
                                    </form>
                                </div>
                            </div>
                        </div> 
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-center w-100 mx-auto" id="myTable">
                                <thead>
                                    <tr>
                                        
                                        <th class="text-center"> ID</th>
                                        <th class="text-center"> Name </th>
                                        <th class="text-center"> Image </th>
                                        <th class="text-center"> Parent</th>
                                        <th class="text-center"> Status</th>
                                        <th class="text-center">Created At</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                            
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{$category->id}}</td>
                                                <td>{{ $category->name}}</td>
                                                <td><img src="{{ asset('storage/'.$category->image) }}" height="50" width="50"></td>
                                                <td style="">{{$category->parent_id}}</td>
                                                <td style="">{{$category->status}}</td>
                                                <td style="">{{$category->created_at}}</td>
                                                <td>
                                                    <a class="btn" href="{{ route('categories.edit',$category->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #01bacf;">
                                                            <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"/>
                                                            <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"/>
                                                        </svg>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('categories.destroy',$category->id) }}" method="post" onSubmit="return confirm('Are You Sure To Delete This Category?')">
                                                        @csrf
                                                        @method("DELETE")
                                                        <!-- <input type="hidden" name="_method" value="delete"> -->
                                                        <button class="btn btn-sm bg-transparent"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" style="fill: rgba(245, 8, 8, 1);">
                                                                <path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path>
                                                                <path d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                                                            </svg></button>
                                                    </form>
                                                </td>
                                        
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-danger fw-bold">No categories defined. </td>
                                            </tr>    
                                        @endforelse
                                    
                                </tbody>
                            </table>
                            {{ $categories->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
          
            </div>
        </div>
    </div>
   
</div>
</div>

@endsection
