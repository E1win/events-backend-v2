function userData() {
  return {
    currentUser: null,
    setCurrentUser(user) {
      this.currentUser = user;
    },
    formatNameOfUser(user) {
      if (user.prefix != null) {
        return `${user.firstName} ${user.prefix} ${user.lastName}`;
      }

      return `${user.firstName} ${user.lastName}`;
    }
  }
}
/**
 * All data for current user.
 */

