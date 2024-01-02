@extends('admin.layouts.master')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Product</h1>
            </div>
            <div class="col-sm-6 text-right">

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
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                <p> </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                <p> </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="number" min="0" name="quantity" id="quantity" class="form-control"
                                    placeholder="quantity">
                                <p> </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if($category->isNotEmpty())
                                    @foreach($category as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <p> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>

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
    $("button[type=submit]").prop['disabled', true];
    $.ajax({
        url: '{{route ("products.store") }}',
        type: 'post',
        data: FormData,
        dataType: 'json',

        success: function(response) {
            if (response['success']) {
                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                    .html("");
                $("#price").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                    .html("");


                window.location.href = "{{ route('products.list') }}";

            } else {
                var errors = response['errors'];
                if (errors && typeof errors === 'object') {
                    if (errors['name']) {
                        $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
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

                    if (errors['category']) {
                        $("#category").addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback')
                            .html(errors['category']);
                    } else {
                        $("#category").removeClass('is-invalid').siblings('p').removeClass(
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