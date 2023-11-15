const loginForm = document.getElementById('form-login');

function authData() {

  return {
    user: null,
    login() {
      // . . .
    },
    logout() {
      fetch(API_URL + `/logout`, {
        credentials: "same-origin",
        method: "POST",
        body: formData
      }).then(response => response.json())
        .then(event => this.event = event);   
    },
  }
}