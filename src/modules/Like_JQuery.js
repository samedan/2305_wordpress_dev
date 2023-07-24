import $ from "jquery";

class Like {
  constructor() {
    this.events();
  }

  events() {
    $(".like-box").on("click", this.ourClickDispather.bind(this));
  }

  // methods
  ourClickDispather(e) {
    // A specific target to click the HTML element around the Heart (the box)
    var currentLikeBox = $(e.target).closest(".like-box");
    if (currentLikeBox.attr("data-exists") == "yes") {
      // fresh values
      // if already liked
      this.deleteLike(currentLikeBox);
    } else {
      this.createLike(currentLikeBox);
    }
  }

  createLike(currentLikeBox) {
    // currentLikeBox is the parent span element of teh heart
    $.ajax({
      beforeSend: (xhr) => {
        // NONCE
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/university/v1/manageLike",
      type: "POST",
      data: { professorId: currentLikeBox.data("professor") },
      success: (response) => {
        currentLikeBox.attr("data-exists", "yes"); // fill the heart
        var likeCount = parseInt(
          currentLikeBox.find(".like-count").html(), // fetch the number next to heart
          10
        ); // base 10 number
        likeCount++;
        currentLikeBox.find(".like-count").html(likeCount);
        currentLikeBox.attr("data-like", response); // response is the id of the like
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }

  deleteLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        // NONCE
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/university/v1/manageLike",
      data: {
        like: currentLikeBox.attr("data-like"),
      },
      type: "DELETE",
      success: (response) => {
        currentLikeBox.attr("data-exists", "no"); // fill the heart
        var likeCount = parseInt(
          currentLikeBox.find(".like-count").html(), // fetch the number next to heart
          10
        ); // base 10 number
        likeCount--;
        currentLikeBox.find(".like-count").html(likeCount);
        currentLikeBox.attr("data-like", ""); // response is the id of the like
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
}

export default Like;
