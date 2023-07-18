import $ from "jquery";

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $("#my-notes").on("click", ".delete-note", this.deleteNote);
    $("#my-notes").on("click", ".edit-note", this.editNote.bind(this));
    $("#my-notes").on("click", ".update-note", this.updateNote.bind(this)); // Save button
    $(".submit-note").on("click", this.createNote.bind(this));
  }

  // Methods
  deleteNote(e) {
    // from page-my-notes.php comes <li data-id="<?php the_ID(); ?>">
    var thisNote = $(e.target).parents("li");
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url:
        universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.data("id"),
      type: "DELETE",
      success: (response) => {
        // JQueyr slideUp removes an element
        thisNote.slideUp();
        console.log("delete success");
        console.log(response);
      },
      error: (response) => {
        console.log("Error delete");
        console.log(response);
      },
    });
  }

  // POST CREATE Submit Note //
  createNote(e) {
    var ourNewPost = {
      title: $(".new-note-title").val(),
      content: $(".new-note-body").val(),
      status: "publish", // default value is 'draft'
    };
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/wp/v2/note/",
      type: "POST",
      data: ourNewPost,
      success: (response) => {
        $(".new-note-title, .new-note-body").val(""); // clear the form
        $(`<li data-id="${response.id}">
              <input readonly class="note-title-field" value="${response.title.raw}">
              <span class="edit-note"><i class="fa fa-pencil" area-hidden="true"></i> Edit</span>
              <span class="delete-note"><i class="fa fa-trash-o" area-hidden="true"></i> Delete</span>
              <textarea readonly class="note-body-field">${response.content.raw}</textarea>
              <span class="update-note btn btn--blue btn--small">
                <i class="fa fa-arrow-right" area-hidden="true"></i> Save</span>
            </li>
        `)
          .prependTo("#my-notes")
          .hide()
          .slideDown();
        console.log("Update success");
        console.log(response);
      },
      error: (response) => {
        console.log("Error delete");
        console.log(response);
      },
    });
  }
  // End CREATE Note //

  // EDIT note //
  editNote(e) {
    // from page-my-notes.php comes <li data-id="<?php the_ID(); ?>">
    var thisNote = $(e.target).parents("li");
    if (thisNote.data("state") == "editable") {
      // make read only
      this.makeNoteReadOnly(thisNote);
    } else {
      // make editable
      this.makeNoteEditable(thisNote);
    }
  }

  makeNoteEditable(thisNote) {
    thisNote
      .find(".edit-note")
      .html('<i class="fa fa-times" area-hidden="true"></i> Cancel');
    thisNote
      .find(".note-title-field, .note-body-field")
      .removeAttr("readonly")
      .addClass("note-active-field");
    thisNote.find(".update-note").addClass("update-note--visible");
    thisNote.data("state", "editable");
  }
  makeNoteReadOnly(thisNote) {
    thisNote
      .find(".edit-note")
      .html('<i class="fa fa-pencil" area-hidden="true"></i> Edit');
    thisNote
      .find(".note-title-field, .note-body-field")
      .attr("readonly", "readonly")
      .removeClass("note-active-field");
    thisNote.find(".update-note").removeClass("update-note--visible");
    thisNote.data("state", "cancel");
  }
  // End EDIT note //

  // UPDATE note //
  updateNote(e) {
    // from page-my-notes.php comes <li data-id="<?php the_ID(); ?>">
    var thisNote = $(e.target).parents("li");
    var ourUpdatedPost = {
      title: thisNote.find(".note-title-field").val(),
      content: thisNote.find(".note-body-field").val(),
    };
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url:
        universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.data("id"),
      type: "POST",
      data: ourUpdatedPost,
      success: (response) => {
        this.makeNoteReadOnly(thisNote);
        console.log("Update success");
        console.log(response);
      },
      error: (response) => {
        console.log("Error delete");
        console.log(response);
      },
    });
  }
  // End UPDATE note //
}

export default MyNotes;
