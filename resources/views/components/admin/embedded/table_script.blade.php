<!-- DataTables  & Plugins -->
<script src="js/admin-js/plugins/jquery.dataTables.min.js"></script>
<script src="js/admin-js/plugins/dataTables.bootstrap4.min.js"></script>
<script src="js/admin-js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="js/admin-js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="js/admin-js/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>

<!-- Page specific script -->
<script>
    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
