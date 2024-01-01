$(document).ready(function () {
    if (!$.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    } else {
        $('#example').DataTable().destroy();
        $('#example').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    }
});
