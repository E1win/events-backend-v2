const eventUpdateForm = document.getElementById('form-event-update');

function eventData() {
  return {
    event: {},
    isModalOpen: false,

    setEvent(event) {
      this.event = event;
    },
    updateEvent(eventId) {
      let formData = new FormData(eventUpdateForm);

      fetch(API_URL + `/events/${eventId}`, {
        credentials: "same-origin",
        method: "POST",
        body: formData
      }).then(response => response.json())
        .then(event => this.event = event);        
    },
    deleteEvent(eventId) {
      fetch(API_URL + `/events/${eventId}`, {
        credentials: "same-origin",
        method: "DELETE",
      }).then(redirect("/events"));
    },
    setEventCompleted(eventId, completed) {
      let body = JSON.stringify({
        'completed': completed
      });
      
      fetch(API_URL + `/events/${eventId}/completed`, {
        credentials: "same-origin",
        method: "POST",
        body: body
      }).then(response => response.json())
        .then(event => this.event = event);  
    },

    showModal() {
      this.isModalOpen = true;
    },
    hideModal() {
      this.isModalOpen = false;
    }
  }
}