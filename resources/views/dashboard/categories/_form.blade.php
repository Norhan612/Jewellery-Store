
@if($errors->any())
<div class="alert alert-danger">
    <h3>Error Occured!</h3>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-group">
    <label for="name">Category Name</label>
    <x-form.input type="text" name="name" value="{{ $category->name }}" />
</div>

<div class="form-group">
    <label for="parent_id">Category Parent</label>
    <select class="form-control form-select" name="parent_id" id="parent_id">
        <option value="">Primry Category</option>
        @foreach($parents as $parent)
            <option value="{{$parent->id}}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{$parent->name}}</option>
        @endforeach
    </select>    
</div>

<div class="form-group">
    <label for="description">Description</label>
    <x-form.textarea name="description" value="{{ $category->description }}" />
</div>

<div class="form-group">
    <x-form.label id="image">Image</x-form.label>
    <x-form.input type="file" name="image" id="image" accept="image/*" />
 
    @if ($category->image)
        <img src="{{ asset('storage/'.$category->image) }}" height="50" width="50">
    @endif
</div>

<div class="form-group">
    <label for="image">Status</label>
    <div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="active" @checked(old('status', $category->status) == 'active')>
        <label class="form-check-label">
            Active
        </label>
        </div>
        <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="inactive" @checked(old('status', $category->status) == 'inactive')>
        <label class="form-check-label">
        Inactive
        </label>
        </div>
    </div>
</div>
<div class="form-group">
   <button type="submit" class="btn btn-primary">{{ $button_lable ?? 'Save' }}</button>
</div>
