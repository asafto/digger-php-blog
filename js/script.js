$('#image').on('change', function (e) {
  console.log(123);
  $('.custom-file-label').text(e.target.files[0].name);
});
// if (document.querySelector('.main')) {
//   document.querySelector('#image').addEventListener('change', (e) => {
//     document.querySelector('.custom-file-label').textContent =
//       e.target.files[0].name;
//   });
// }
