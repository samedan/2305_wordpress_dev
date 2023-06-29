import $ from "jquery";

class Search {
  constructor() {
    this.resultsDiv = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term"); // down in footer
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    // keeps track of the previous search value
    this.typingValue;
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
    // only if the keystroke changed the search field in some way
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer); // wait 2 seconds before sending input data

      if (this.searchField.val()) {
        // field has text
        if (!this.isSpinnerVisible) {
          // if in the 2 seconds visible delay
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        // runs after every key stroke
        this.previousValue = this.searchField.val();
      } else {
        // field is empty, deleted inout
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }
    this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
  }

  getResults() {
    this.resultsDiv.html("search results");
    this.isSpinnerVisible = false;
  }

  keyPressDispatcher(e) {
    // console.log(e.keyCode);
    if (
      e.keyCode == 83 && // s key
      !this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    ) {
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
