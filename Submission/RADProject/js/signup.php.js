// Signup Modal
{
  function validateSignup(form) {
    form.btnSignup.disabled = true;
    var name = form.fullName.value;
    var email = form.email.value;
    var news = form.newsletter.value;
    var notifs = form.notifications.value;

    var data = {
      name: name,
      email: email,
      news: news,
      notifs: notifs,
    };

    $.ajax({
      url: "includes/signup.inc.php",
      type: "POST",
      data: data,
      success: function (response) {
        document.getElementById("messageSignup").innerHTML = response;
        return false;
      },
      error: function () {
        alert("An error occured");
        return false;
      },
    });
    form.btnSignup.disabled = false;
    return false;
  }

  var modalSignup = document.getElementById("modalSignup");
  var btnShowSignup = document.getElementById("btnShowSignup");
  var closeSignup = document.getElementById("closeSignup");

  btnShowSignup.onclick = function () {
    modalSignup.style.display = "block";
  };

  closeSignup.onclick = function () {
    modalSignup.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modalSignup) {
      modalSignup.style.display = "none";
    }
  };
}

//Update Modal
{
  function validateUpdate(form) {
    form.btnUpdateDetails.disabled = true;
    var name = form.fullName.value;
    var email = form.email.value;
    var news = form.newsletter.value;
    var notifs = form.notifications.value;

    var data = {
      name: name,
      email: email,
      news: news,
      notifs: notifs,
    };

    $.ajax({
      url: "includes/updateSub.inc.php",
      type: "POST",
      data: data,
      success: function (response) {
        document.getElementById("messageUpdate").innerHTML = response;
        return false;
      },
      error: function () {
        alert("An error occured");
        return false;
      },
    });
    form.btnUpdateDetails.disabled = false;
    return false;
  }

  {
    var modalUpdate = document.getElementById("modalUpdate");
    var btnShowUpdate = document.getElementById("btnShowUpdate");
    var closeUpdate = document.getElementById("closeUpdate");

    btnShowUpdate.onclick = function () {
      modalUpdate.style.display = "block";
    };

    closeUpdate.onclick = function () {
      modalUpdate.style.display = "none";
    };

    window.onclick = function (event) {
      if (event.target == modalUpdate) {
        modalUpdate.style.display = "none";
      }
    };
  }
}

//Unsub Modal
{
  function validateUnsub(form) {
    form.btnUnsub.disabled = true;
    var email = form.email.value;

    var data = {
      email: email,
    };

    $.ajax({
      url: "includes/sendUnsub.inc.php",
      type: "POST",
      data: data,
      success: function (response) {
        document.getElementById("messageUnsub").innerHTML = response;
        return false;
      },
      error: function () {
        alert("An error occured");
        return false;
      },
    });
    form.btnUnsub.disabled = false;
    return false;
  }

  {
    var modalUnsub = document.getElementById("modalUnsub");
    var btnShowUnsub = document.getElementById("btnShowUnsub");
    var closeUnsub = document.getElementById("closeUnsub");

    btnShowUnsub.onclick = function () {
      modalUnsub.style.display = "block";
    };

    closeUnsub.onclick = function () {
      modalUnsub.style.display = "none";
    };

    window.onclick = function (event) {
      if (event.target == modalUnsub) {
        modalUnsub.style.display = "none";
      }
    };
  }
}
