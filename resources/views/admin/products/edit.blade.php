@extends('admin.layouts.master')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('products.list')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="productform" name="productform">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{$product->name}}" class="form-control"
                                    placeholder="Name">
                                <p> </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price" value="{{$product->price}}"
                                    class="form-control" placeholder="Slug">
                                <p> </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="number" min="0" name="quantity" id="quantity"
                                    value="{{$product->quantity}}" class="form-control" placeholder="quantity">
                                <p> </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @foreach ($data['category'] as $category)
                                    <option value="{{ $category->id }}" @if ($product->category_id == $category->id)
                                        selected
                                        @endif
                                        >
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <p> </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('products.list')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('coustomjs')

<script>
$("#productform").submit(function(e) {
    e.preventDefault();
    var FormData = $(this).serializeArray();
    $.ajax({
        url: '{{route ("products.update",$product->id) }}',
        type: 'put',
        data: FormData,
        dataType: 'json',

        success: function(response) {
            if (response['success']) {

                window.location.href = "{{ route('products.list') }}";

                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                    .html("");
                $("#price").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                    .html("");

            } else {

                if (response['notFound'] == true) {
                    window.location.href = "{{ route('products.list') }}";

                }

                var errors = response['errors'];
                if (errors && typeof errors === 'object') {
                    if (errors['name']) {
                        $("#name").addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback')
                            .html(errors['name']);
                    } else {
                        $("#name").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    }

                    if (errors['price']) {
                        $("#price").addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback')
                            .html(errors['price']);
                    } else {
                        $("#price").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    }
                }
            }
        },
        error: function(jqXHR, exception) {

            console.log("Somthing failed");
        }

    });
});
</script>



@endsection