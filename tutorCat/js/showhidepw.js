var state,
  cstate = false;

function toggle() {
  if (state) {
    document.getElementById("password").setAttribute("type", "password");
    state = false;
    document.getElementById("pwicon").className = "fa fa-eye";
  } else {
    document.getElementById("password").setAttribute("type", "text");
    document.getElementById("pwicon").className = "fa fa-eye-slash";
    state = true;
  }
}

function togglec() {
  if (cstate) {
    document.getElementById("cpassword").setAttribute("type", "password");
    cstate = false;
    document.getElementById("cpwicon").className = "fa fa-eye";
  } else {
    document.getElementById("cpassword").setAttribute("type", "text");
    document.getElementById("cpwicon").className = "fa fa-eye-slash";
    cstate = true;
  }
}
