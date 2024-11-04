$(document).ready(function() {   
	const base_url = window.location.origin + '/projects/bpk-sisbukupersediaan/';

  $('.select2-kelompok').select2({
    dropdownParent: $('#adding-modal'),
    placeholder: "Masukan minimal 3 karakter",
		allowClear: true,
		minimumInputLength: 3,
		ajax: {
			url: base_url + 'ckelompok/getListByName',
			dataType:'json',
			delay: 250,
			data: function(params) {
				return {
					keyword: params.term
				};
			},
			processResults: function(data) {
				var results = [];
				$.each(data, function(index,item) {
					results.push({
						id: item.id,
						text: item.name
					});
				});

				return {
					results: results
				}
			},
		}
  });
  
  $('.select2-satuan').select2({
    dropdownParent: $('#adding-modal'),
    placeholder: "Masukan minimal 3 karakter",
		allowClear: true,
		minimumInputLength: 3,
		ajax: {
			url: base_url + 'csatuan/getListByName',
			dataType:'json',
			delay: 250,
			data: function(params) {
				return {
					keyword: params.term
				};
			},
			processResults: function(data) {
				var results = [];
				$.each(data, function(index,item) {
					results.push({
						id: item.id,
						text: item.name
					});
				});

				return {
					results: results
				}
			},
		}
  });

  $('.select2-kelompok-edit').select2({
    dropdownParent: $('#updating-modal'),
    placeholder: "Masukan minimal 3 karakter",
		allowClear: true,
		minimumInputLength: 3,
		ajax: {
			url: base_url + 'ckelompok/getListByName',
			dataType:'json',
			delay: 250,
			data: function(params) {
				return {
					keyword: params.term
				};
			},
			processResults: function(data) {
				var results = [];
				$.each(data, function(index,item) {
					console.log(index,item);
					results.push({
						id: item.id,
						text: item.name
					});
				});

				return {
					results: results
				}
			},
		}
  });
  
  $('.select2-satuan-edit').select2({
    dropdownParent: $('#updating-modal'),
    placeholder: "Masukan minimal 3 karakter",
		allowClear: true,
		minimumInputLength: 3,
		ajax: {
			url: base_url + 'csatuan/getListByName',
			dataType:'json',
			delay: 250,
			data: function(params) {
				return {
					keyword: params.term
				};
			},
			processResults: function(data) {
				var results = [];
				$.each(data, function(index,item) {
					results.push({
						id: item.id,
						text: item.name
					});
				});

				return {
					results: results
				}
			},
		}
  });

  if ('.select-tagihan') {
    $('.select-tagihan').select2({
        multiple: true,
    });  
  }
  
  if ('.select-item') {
    $('.select-item').select2({
        placeholder: "Pilih Bawaan"
    });  
  }

});
