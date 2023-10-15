// https://stackoverflow.com/questions/39565706/post-request-with-fetch-api
// https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch

const BASE_URL = "http://localhost:8000/api";

async function login() {
  const response = await fetch(BASE_URL + "/login", {
    method: "post",
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      email: myEmail,
      password: myPassword
    }),
  });

  return response.json();
}