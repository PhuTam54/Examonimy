@extends("layouts.admin")
@section("title", "Admin | Product Add")
@section("before_css")
{{--    @include("components.admin.embedded.table_head")--}}
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.table2.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="admin/product-add" method="post">
                @csrf
                @method('POST')
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Add new product</h3>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputName">Name</label>
                                            <input
                                                name="name"
                                                value="{{ old("name") }}"
                                                type="text"
                                                class="form-control"
                                            >
                                            @error("name")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Price</label>
                                            <input
                                                name="price"
                                                value="{{ old("price") }}"
                                                type="number"
                                                class="form-control"
                                            >
                                            @error("price")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Quantity</label>
                                            <input
                                                name="qty"
                                                value="{{ old("qty") }}"
                                                type="number"
                                                class="form-control"
                                            >
                                            @error("qty")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputCategory">Category</label>
                                            <select name="category" id="inputCategory" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                @foreach($categories as $category)
                                                    <option @if(old("category") == "$category->id") selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("category")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputDescription">Description</label>
                                            <textarea id="inputDescription" class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                                            @error("description")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus">Status</label>
                                            <select name="status" id="inputStatus" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                <option @if(old("status") == "1") selected @endif value="1">In stock</option>
                                                <option @if(old("status") == "2") selected @endif value="2">Out of stock</option>
                                            </select>
                                            @error("status")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Image</label>
                                            <input
                                                name="thumbnail"
                                                type="file"
                                                class="form-control"
                                                accept="image/*,.pdf"
                                            >
                                            @if (old('thumbnail'))
                                                <p class="text-info">Old thumb nail: {{ old("thumbnail") }}</p>
                                                <p class="text-danger">Please choose again.</p>
                                            @endif
                                            @error("thumbnail")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- /.card-body -->
                                </div>
                            <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <a href="admin/admin-table2" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Create new Product" class="btn btn-success float-right">
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")
{{--    @include("components.admin.embedded.table_script")--}}
@endsection
