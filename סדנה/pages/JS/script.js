// validate the  name of the user
function validateName(input) {
  var pattern = /^[a-zA-Z]*$/;
  if (!pattern.test(input.value)) {
    input.setCustomValidity("Please enter a valid name in english");
  } else {
    input.setCustomValidity("");
  }
}
// validate the email of the user
function validateEmail(input) {
  var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  if (!pattern.test(input.value)) {
    input.setCustomValidity("Please enter a valid email address");
  } else {
    input.setCustomValidity("");
  }
}
// validate the password at register of the user
$(document).ready(function () {
  $("#pass, #confirmPass").on("input", function () {
    var passwordValue = $("#pass").val();
    var confirmPasswordValue = $("#confirmPass").val();

    if (passwordValue !== confirmPasswordValue) {
      $("#confirmPass")[0].setCustomValidity("Passwords do not match");
    } else {
      $("#confirmPass")[0].setCustomValidity("");
    }
  });
});
