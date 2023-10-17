// https://stackoverflow.com/questions/39565706/post-request-with-fetch-api
// https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch

const BASE_URL = "http://localhost:80";
const API_URL = BASE_URL + "/api";

async function doRequest(url, method = "GET", body = {}, headers = {}) {
  // Fetch not setting cookies for some reason.
  // probably something with options here
  // 

  const response = await fetch(API_URL + url, {
    credentials: "include",
    method: method,
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      ...headers
    },
    // body: JSON.stringify(body)
    ...createBody(body, method)
  });

  console.log(response);

  return response.json();
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
      console.log(response);
      // window.location = BASE_URL + "/login";
    }
  } catch (error) {
    console.error(error);
  }

}

async function login(formData = {}) {
  const response = await doRequest('/login', "POST", formData);

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