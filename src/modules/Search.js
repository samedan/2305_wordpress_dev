import $ from "jquery";

class Search {
  constructor() {
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term"); // down in footer
    this.events();
    this.isOverlayOpen = false;
    this.typingTimer;
  }

  // events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keydown", this.typingLogic.bind(this));
  }

  // methods
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }

  typingLogic() {
    clearTimeout(this.typingTimer);
    this.typingTimer = setTimeout(function () {
      console.log("timeout");
    }, 2000);
  }

  keyPressDispatcher(e) {
    // console.log(e.keyCode);
    if (e.keyCode == 83 && !this.isOverlayOpen) {
      // s key
      this.openOverlay();
      console.log("ran open");
    }
    if (e.keyCode == 27 && this.isOverlayOpen) {
      // escape key
      this.closeOverlay();
      console.log("ran close");
    }
  }
}

export default Search;
