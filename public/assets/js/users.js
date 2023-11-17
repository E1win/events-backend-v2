function usersData() {
  return {
    users: [],
    currentUser: {},
    setCurrentUser(user) {
      this.currentUser = user;
    },
    getUsers() {
      fetch('api/users')
        .then(response => response.json())
        .then(users => this.users = users);
    },
    addEvent() {
      let formData = new FormData(eventCreateForm);

      fetch(API_URL + '/events', {
        credentials: "same-origin",
        method: "POST",
        body: formData
      }).then(response => response.json())
        .then(event => this.events.unshift(event));
    },
    async changeUserRole(userId, roleId) {
      let body = JSON.stringify({
        'roleId': roleId
      });
      
      return await fetch(API_URL + `/users/${userId}/role`, {
        credentials: "same-origin",
        method: "POST",
        body: body
      }).then(response => response.json());
    }
  }
}