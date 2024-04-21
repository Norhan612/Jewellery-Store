@extends('layouts.dashboard')

@section('title','Trashed Categories')

@section('breadcrumb')
  @parent 
  <li class="breadcrumb-item active">Categories</li>
  <li class="breadcrumb-item active">Trash</li>
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
                                <a href="{{ route('categories.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: #00a8bd;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm2.707 14.293-1.414 1.414L7.586 12l5.707-5.707 1.414 1.414L10.414 12l4.293 4.293z"></path></svg>
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
                                        <th class="text-center"> Status</th>
                                        <th class="text-center">Deleted At</th>
                                        <th colspan="2" class="text-center"></th>
                                       
                                            
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{$category->id}}</td>
                                                <td>{{ $category->name}}</td>
                                                <td><img src="{{ asset('storage/'.$category->image) }}" height="50" width="50"></td>
                                                <td style="">{{$category->status}}</td>
                                                <td style="">{{$category->deleted_at}}</td>
                                                <td>
                                                    <form action="{{ route('categories.restore',$category->id) }}" method="post" onSubmit="return confirm('Are You Sure To Restore This Category?')">
                                                        @csrf
                                                        @method("put")
                                                        <button type="submit" class="btn btn-sm btn-outline-info">
                                                            Restore
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('categories.force-delete',$category->id) }}" method="post" onSubmit="return confirm('Are You Sure To Delete This Category?')">
                                                        @csrf
                                                        @method("DELETE")
                                                        <!-- <input type="hidden" name="_method" value="delete"> -->
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                        
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-danger fw-bold">No categories defined. </td>
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
