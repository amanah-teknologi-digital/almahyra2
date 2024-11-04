$(document).ready(function() {
    const base_url = window.location.origin + '/projects/bpk-sisbukupersediaan/';

    $('#datatables_barang').DataTable({ 

        "processing": true, 
        "serverSide": true, 
        "order": [], 
         
        "ajax": {
            "url": base_url + 'cbarang/get_data',
            "type": "POST"
        },

         
        "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
        ],         
    });

});