// https://stackoverflow.com/questions/39565706/post-request-with-fetch-api
// https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch

const BASE_URL = "http://localhost:80";
const API_URL = BASE_URL + "/api";
const TOKEN_NAME = 'EventsCMSSession';

const loginForm = document.getElementById('form-login');
const eventForm = document.getElementById('form-event');

let roles = ['User', 'Admin', 'Owner'];

async function doRequest(url, method = "GET", body = {}, headers = {}) {
  const response = await fetch(API_URL + url, {
    credentials: "same-origin",
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
  console.log('logout function called');

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

  console.log(Object.fromEntries(formData));

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

async function createEvent() {
  let formData = new FormData(eventForm);

  console.log(Object.fromEntries(formData));
  
  try {

    let response = await fetch(API_URL + '/events', {
      credentials: "same-origin",
      method: "POST",
      body: formData
    });
  
    response = response.json();
    
    console.log(response);
  } catch (error) {
    console.error(error);
  }
}

async function updateEvent(eventId) {
  let formData = new FormData(eventForm);

  console.log(Object.fromEntries(formData));
  console.log(eventId);

  
  try {
    let response = await fetch(API_URL + `/events/${eventId}`, {
      credentials: "same-origin",
      method: "POST",
      body: formData
    });
  
    return response.json();
    
    console.log(response);
  } catch (error) {
    console.error(error);
  }
}

async function events()
{
  console.log('testing what the fuck');

  try {
    return await doRequest('/events');
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