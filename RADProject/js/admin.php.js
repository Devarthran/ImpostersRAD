// Create Staff Modal
{
  function validateStaff(form) {
    form.btnCreateStaff.disabled = true;
    var name = form.fullName.value;
    var email = form.email.value;
    var password = form.password.value;
    var al = form.access_level.value;

    var data = {
      name: name,
      email: email,
      password: password,
      al: al,
    };

    $.ajax({
      url: "includes/admin_tools/createStaff.inc.php",
      type: "POST",
      data: data,
      success: function (response) {
        document.getElementById("messageStaff").innerHTML = response;
        setTimeout(function(){
          location.reload();
        },5000);
        
      },
      error: function () {
        alert("An error occured");
        return false;
      },
    });
    form.btnCreateStaff.disabled = false;
    return false;
  }

  var modalStaffCreate = document.getElementById("modalStaffCreate");
  var btnShowStaffModal = document.getElementById("btnShowStaffModal");
  var closeStaffCreate = document.getElementById("closeStaffCreate");

  btnShowStaffModal.onclick = function () {
    modalStaffCreate.style.display = "block";
  };

  closeStaffCreate.onclick = function () {
    modalStaffCreate.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modalStaffCreate) {
      modalStaffCreate.style.display = "none";
    }
  };
}
