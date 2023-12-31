// https://stackoverflow.com/questions/39565706/post-request-with-fetch-api
// https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch

const BASE_URL = window.location.origin;
const API_URL = BASE_URL + "/api";
const TOKEN_NAME = 'EventsCMSSession';

const loginForm = document.getElementById('form-login');

let roles = ['User', 'Admin', 'Owner'];

async function doRequest(url, method = "GET", body = {}, headers = {}) {
  const response = await fetch(API_URL + url, {
    credentials: "include",
    method: method,
    headers: {
      // 'Accept': 'application/json',
      // 'Content-Type': 'application/json',
      // ...headers
    },
    ...createBody(body, method)
  });

  return response.json();
}

function addAuthHeaders() {
  let headers = {};
  const token = getCookie(TOKEN_NAME);

  if (token !== "") {
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
  try {
    const response = await doRequest('/logout', "POST");
    
    if (response.hasOwnProperty("error")) {
      console.error(response['error']);
    } else {
      unsetCookie(TOKEN_NAME);
      redirect("/login");
    }
  } catch (error) {
    console.error(error);
  }

}

async function login() {
  let formData = new FormData(loginForm);

  try {
    const response = await doRequest('/login', "POST", Object.fromEntries(formData));

    if (response.hasOwnProperty("error")) {
      console.error(response['error']);
    } else {
      const token = response['token'];

      setCookie(token['name'], token['value'], token['expires']);

      redirect("/");
    }
  } catch (error) {
    console.error(error);
  }

}
/**
 * PUBLIC HELPER FUNCTIONS
 */

function formatDate(date) {
  return date.split(' ')[0].split('-').reverse().join('/');
}

function formatLastOnline(timestamp) {
  timestamp = timestamp * 1000; // convert seconds to ms

  let currentTime = Date.now();

  if (timestamp > currentTime) {
    return "Now";
  }

  return timeSince(timestamp);
}

function formatRole(roleId) {
  return roles[roleId - 1];
}


/**
 * PRIVATE HELPER FUNCTIONS
 */

function timeSince(timestamp) {
  let seconds = Math.floor((Date.now() - timestamp) / 1000);

  let interval = seconds / 31536000;

  if (interval > 1) {
    return Math.floor(interval) + " years ago";
  }
  interval = seconds / 2592000;
  if (interval > 1) {
    return Math.floor(interval) + " months ago";
  }
  interval = seconds / 86400;
  if (interval > 1) {
    return Math.floor(interval) + " days ago";
  }
  interval = seconds / 3600;
  if (interval > 1) {
    return Math.floor(interval) + " hours ago";
  }
  interval = seconds / 60;
  if (interval > 1) {
    return Math.floor(interval) + " minutes ago";
  }
  return Math.floor(seconds) + " seconds ago";
}

function setCookie(name, value, expiresTimestamp) {
  const date = new Date();
  date.setTime(expiresTimestamp * 1000); // Convert seconds to milliseconds
  let expires = "expires=" + date.toUTCString();
  document.cookie = name + "=" + value + "; " + expires + "; path=/;";
}

function unsetCookie(name) {
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function redirect(location) {
  window.location = BASE_URL + location;
}