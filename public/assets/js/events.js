const eventCreateForm = document.getElementById('form-event-create');

function eventsData() {
  return {
    events: [],
    getEvents() {
      fetch('api/events')
        .then(response => response.json())
        .then(events => this.events = events);
    },
    addEvent() {
      let formData = new FormData(eventCreateForm);

      fetch(API_URL + '/events', {
        credentials: "same-origin",
        method: "POST",
        body: formData
      }).then(response => response.json())
        .then(event => this.events.unshift(event));
    }
  }
}