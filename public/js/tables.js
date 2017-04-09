$('#apartments-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: 'https://datatables.yajrabox.com/eloquent/add-edit-remove-column-data',
    columns: [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'created_at', name: 'created_at'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});