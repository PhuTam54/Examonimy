@extends("layouts.admin")
@section("title", "Admin | Products Tables")
@section("before_css")
    <!-- DataTables -->
    <link rel="stylesheet" href="css/admin-css/plugins/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/admin-css/plugins/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="css/admin-css/plugins/buttons.bootstrap4.min.css">
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.table2.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Category</th>
                                    <th>Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->category_id }}</td>
                                    <td>{{ $product->created_at }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Category</th>
                                    <th>Created</th>
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
