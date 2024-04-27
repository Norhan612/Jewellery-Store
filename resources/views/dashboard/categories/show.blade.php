@extends('layouts.dashboard')

@section('title', $category->name)

@section('breadcrumb')
  @parent 
  <li class="breadcrumb-item active">Categories</li>
  <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover text-center w-100 mx-auto" id="myTable">
            <thead>
                <tr>
                                        
                    <th class="text-center"> Name </th>
                    <th class="text-center"> Image </th>
                    <th class="text-center"> Store</th>
                    <th class="text-center"> Status</th>
                    <th class="text-center">Created At</th>
                                            
                </tr>
            </thead>
            <tbody>
                @php
                    $products = $category->products()->with('store')->latest()->paginate(5);
                @endphp                 
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->name}}</td>
                        <td><img src="{{ asset('storage/'.$product->image) }}" height="50" width="50"></td>
                        <td style="">{{$product->store->name}}</td>
                        <td style="">{{$product->status}}</td>
                        <td style="">{{$product->created_at}}</td>                    
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-danger fw-bold">No products defined. </td>
                    </tr>    
                @endforelse
                                    
            </tbody>
        </table>
        {{ $products->withQueryString()->links() }}      
    </div>
</div>


@endsection
