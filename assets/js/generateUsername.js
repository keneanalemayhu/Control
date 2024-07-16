function generateUsername() {
  var firstName = document.getElementById("firstNameInput").value.trim();
  var lastName = document.getElementById("lastNameInput").value.trim();
  var usernameInput = document.getElementById("usernameInput");

  if (firstName && lastName) {
    var username = (firstName + "." + lastName).toLowerCase(); // Combines to form "first.last" and converts to lowercase
    usernameInput.value = username;
  } else if (firstName) {
    usernameInput.value = firstName.toLowerCase(); // Converts first name to lowercase
  } else {
    usernameInput.value = "";
  }
}
