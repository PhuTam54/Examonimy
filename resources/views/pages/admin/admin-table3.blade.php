@extends("layouts.admin")
@section("title", "Admin | Table 3")
@section("before_css")
    <!-- jsGrid -->
    <link rel="stylesheet" href="css/admin-css/plugins/jsgrid/jsgrid.min.css">
    <link rel="stylesheet" href="css/admin-css/plugins/jsgrid/jsgrid-theme.min.css">
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.table3.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">jsGrid</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="jsGrid1"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")
    <!-- jsGrid -->
    <script src="js/admin-js/plugins/jsgrid/demos/db.js"></script>
    <script src="js/admin-js/plugins/jsgrid/jsgrid.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#jsGrid1").jsGrid({
                height: "100%",
                width: "100%",

                sorting: true,
                paging: true,

                data: db.clients,

                fields: [
                    { name: "Name", type: "text", width: 150 },
                    { name: "Age", type: "number", width: 50 },
                    { name: "Address", type: "text", width: 200 },
                    { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
                    { name: "Married", type: "checkbox", title: "Is Married" }
                ]
            });
        });
    </script>
@endsection
