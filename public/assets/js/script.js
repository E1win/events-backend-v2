// https://stackoverflow.com/questions/39565706/post-request-with-fetch-api
// https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch

const BASE_URL = "http://localhost:80";
const API_URL = BASE_URL + "/api";
const TOKEN_NAME = 'EventsCMSSession';

const loginForm = document.getElementById('form-login');


async function doRequest(url, method = "GET", body = {}, headers = {}) {
  // Fetch not setting cookies for some reason.
  // probably something with options here
  // 

  const response = await fetch(API_URL + url, {
    credentials: "same-origin",
    method: method,
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      ...addAuthHeaders(),
      ...headers
    },
    // body: JSON.stringify(body)
    ...createBody(body, method)
  });

  console.log(response);

  return response.json();
}

function addAuthHeaders() {
  let headers = {};
  const token = localStorage.getItem(TOKEN_NAME);

  if (token !== null) {
    headers['Authorization'] = token;
  }

  return headers;
}

function createBody(body, method) {
  if (method == "GET") {
    return {};
  }

  return {
    'body': JSON.stringify(body)
  }
}

async function logout() {
  console.log('logout function called');

  try {
    const response = await doRequest('/logout', "POST");
    
    if (response.hasOwnProperty("error")) {
      console.error(response['error']);
    } else {
      localStorage.removeItem(TOKEN_NAME);
      document.cookie = TOKEN_NAME + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      window.location = BASE_URL + "/login";
    }
  } catch (error) {
    console.error(error);
  }

}

async function login() {
  let formData = new FormData(loginForm);

  console.log(Object.fromEntries(formData));

  try {
    const response = await doRequest('/login', "POST", Object.fromEntries(formData));

    console.log(response);

    if (response.hasOwnProperty("error")) {
      console.error(response['error']);
    } else {
      localStorage.setItem(TOKEN_NAME, response['token']);
      document.cookie = TOKEN_NAME + '=' + response['token'];

      console.log('set token: ' + response['token']);

      // Cookie is not set, even though it's a web route...
      // can you set cookie from here?
      // or set header

      window.location = BASE_URL + "/";
    }
  } catch (error) {
    console.error(error);
  }

  // depending on response

  // either redirect or show error message

  // const response = await fetch(BASE_URL + "/login", {
  //   method: "post",
  //   headers: {
  //     'Accept': 'application/json',
  //     'Content-Type': 'application/json'
  //   },
  //   body: JSON.stringify({
  //     email: myEmail,
  //     password: myPassword
  //   }),
  // });

  // return response.json();
}


// loginForm.addEventListener("submit", function(e) {
//   login(e);
// })