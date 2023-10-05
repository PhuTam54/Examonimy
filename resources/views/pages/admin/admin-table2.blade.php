@extends("layouts.admin")
@section("title", "Admin | Products Tables")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.table2.content_header")
        <!-- /.content-header -->
        @if(session()->has("add-success"))
            <div class="alert alert-success" role="alert">
                {{ session("add-success") }}
            </div>
        @elseif(session()->has("edit-success"))
            <div class="alert alert-info" role="alert">
                {{ session("edit-success") }}
            </div>
        @elseif(session()->has("delete-success"))
            <div class="alert alert-danger" role="alert">
                {{ session("delete-success") }}
            </div>
        @endif
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a class="btn btn-success btn-md" href="admin/product-add">
                                    <i class="fas fa-plus">
                                    </i>
                                    Add new product
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
{{--                                    <th>Description</th>--}}
                                    <th>Qty</th>
                                    <th>Category</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="">
                                        <img src=" {{ $product->thumbnail }}" width="100" alt="img">
                                    </td>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ $product->price }}</td>
{{--                                    <td>{{ $product->description }}</td>--}}
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->Category->name }}</td>
                                    <td>{{ $product->created_at }}</td>
                                    <td>@if($product->updated_at == $product->created_at) Nothing changed @else{{ $product->updated_at }}@endif</td>
                                    <td class="project-actions text-center">
                                        <a class="btn btn-primary btn-sm" href="admin/product-details/{{ $product->id }}">
                                            <i class="fas fa-folder">
                                            </i>
                                            View
                                        </a>
                                        <a class="btn btn-info btn-sm" href="admin/product-edit/{{ $product->id }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn">
                                            <form action="admin/product-delete/{{ $product->id }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                                <button onclick="return confirm('Are you sure to delete this product???')" class="btn btn-danger btn-sm" style="margin-left: -12px" type="submit">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    Delete
                                                </button>
                                            </form>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Image</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
{{--                                    <th>Description</th>--}}
                                    <th>Qty</th>
                                    <th>Category</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")
    @include("components.admin.embedded.table_script")
@endsection
