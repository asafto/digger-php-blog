$('#image').on('change', function (e) {
  console.log(123);
  $('.custom-file-label').text(e.target.files[0].name);
});


$('#upd-password').on('click', (e) => { 
  if (confirm('Are you sure you want to update your password?')) {
    $('#upd-password').prop('readonly', false).val('');
  }
});