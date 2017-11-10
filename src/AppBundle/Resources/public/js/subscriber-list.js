$(document).ready(function() {
    $('#subscribers').DataTable( {
        "processing": true,
        "serverSide": true,
        "bFilter": false,
        "bInfo": false,
        "ordering": false,
        "ajax": {
            "url": Routing.generate('app_get_subscribers'),
            "type": "POST"
        },
        "columns": [
            { "data": "email" },
            { "data": "name" },
            { "data": "created" },
            { "data": "status" },
            {
                data: null,
                render: function (data, type, row) {
                    return '<button class="remove btn btn-danger btn-remove" data-email="' + row.email +'"">Delete</button>'
                },
                orderable: false
            },
        ]
    } );
} );

$('#subscribers').on('click', '.btn-remove', function (e) {
    var data = {
        'email': $(this).attr("data-email")
    };
    var element = $(this).parent().parent();

    $.ajax({
        url: Routing.generate('app_delete_subscribers'),
        type: "POST",
        data: data,
        dataType  : 'json',
        success: function(response){
            if(response.success == true){
                element.hide();
            }
        },
    })
} );