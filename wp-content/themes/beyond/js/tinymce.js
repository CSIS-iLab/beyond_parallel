(function() {
  var footnoteCount = 1;
  tinymce.PluginManager.add("beyond", function(editor, url) {
    var footnotes = [];
    editor.addButton("note", {
      text: "Footnote",
      icon: null,
      style: "background-color:#FFC726",
      tooltip: "Insert Footnote",
      onclick: function() {
        editor.windowManager.open({
          title: "Insert Footnote Content",
          width: 400,
          height: 400,
          body: [
            {
              type: "textbox",
              multiline: true,
              name: "number",
              label: "Number",
              value: footnoteCount,
              style: "width:20px"
            },

            {
              type: "textbox",
              multiline: true,
              name: "note",
              style: "height:200px"
            },
            {
              type: "Toolbar",
              name: "tools",

              items: [
                tinymce.ui.Factory.create({
                  type: "button",
                  text: "Link",

                  onclick: function(e) {
                    formatText(e, "a");
                  }
                }),
                tinymce.ui.Factory.create({
                  type: "button",
                  text: "Italic",

                  onclick: function(e) {
                    formatText(e, "em");
                  }
                }),
                tinymce.ui.Factory.create({
                  type: "button",
                  text: "Bold",

                  onclick: function(e) {
                    formatText(e, "bold");
                  }
                })
              ]
            }
          ],
          onsubmit: function(e) {
            editor.insertContent(
              "[" + footnoteCount + ". " + e.data.note + "]"
            );
            footnoteCount++;
          }
        });
      }
    });

    editor.addButton("button", {
      text: "Button",
      icon: null,
      style: "background-color:#FFC726",
      tooltip: "Insert Button link",
      onclick: function() {
        var values = [
          {
            text: "Choose a post or add an external URL below",
            value: ""
          }
        ].concat(tinyMCE_posts);

        editor.windowManager.open({
          title: "Insert Button Link",
          width: 600,
          height: 125,
          body: [
            {
              type: "textbox",
              multiline: false,
              name: "title",
              label: "Title",
              placeholder: "Optional Title Attribute"
            },
            {
              type: "listbox",
              name: "id",
              label: "Post",
              values: values
            },
            {
              type: "textbox",
              multiline: false,
              name: "url",
              label: "External URL",
              placeholder: "URL to link to if post is unlisted"
            }
          ],
          onsubmit: function(e) {
            var titleAttr = "";
            if (e.data.title) {
              titleAttr = ' title="' + e.data.title + '"';
            }
            var windowAttr = "";
            if (e.data.window) {
              windowAttr = ' window="' + e.data.window + '"';
            }
            var urlAttr = "";
            if (e.data.url) {
              urlAttr = ' url="' + e.data.url + '"';
            }
            editor.insertContent(
              '[button id="' +
                e.data.id +
                '"' +
                titleAttr +
                windowAttr +
                urlAttr +
                "]"
            );
          }
        });
      }
    });

    editor.addButton("aside", {
      text: "Aside",
      icon: null,
      style: "background-color:#FFC726",
      tooltip: "Insert Aside",
      onclick: function() {
        editor.windowManager.open({
          title: "Insert Aside Content",
          width: 400,
          height: 400,
          body: [
            {
              type: "textbox",
              multiline: true,
              name: "content",

              style: "height:200px"
            },
            {
              type: "Toolbar",
              name: "tools",

              items: [
                tinymce.ui.Factory.create({
                  type: "button",
                  text: "Image",
                  onclick: function(e) {
                    insertImgID();
                  }
                }),
                tinymce.ui.Factory.create({
                  type: "button",
                  text: "Link",
                  onclick: function(e) {
                    formatText(e, "a");
                  }
                }),
                tinymce.ui.Factory.create({
                  type: "button",
                  text: "Italic",

                  onclick: function(e) {
                    formatText(e, "em");
                  }
                }),
                tinymce.ui.Factory.create({
                  type: "button",
                  text: "Bold",

                  onclick: function(e) {
                    formatText(e, "bold");
                  }
                })
              ]
            },
            {
              type: "listbox",
              name: "align",
              label: "Alignment",
              values: [
                {
                  text: "Left",
                  value: "left"
                },
                {
                  text: "Right",
                  value: "right"
                }
              ]
            }
          ],
          onsubmit: function(e) {
            editor.insertContent(
              '[aside align="' +
                e.data.align +
                '"]' +
                e.data.content +
                "[/aside]"
            );
          }
        });
      }
    });
  });

  function insertImgID() {
    window.mb = window.mb || {};
    window.mb.frame = wp.media({
      frame: "post",
      state: "insert",
      library: {
        type: "image"
      },
      multiple: false
    });

    window.mb.frame.on("insert", function() {
      var json = window.mb.frame
        .state()
        .get("selection")
        .first()
        .toJSON();

      if (0 > $.trim(json.url.length)) {
        return;
      }

      var selection = window.getSelection();
      console.log(selection);
      var textarea = selection.anchorNode.querySelector("textarea");
      console.log(textarea);

      if (!textarea) return;

      var oldText = textarea.value;

      var selectionText = selection.toString();

      var formattedSelection =
        '<img src="' + json.url + '" height="100" width="100"/>';

      var end = oldText.slice(textarea.selectionEnd, oldText.length);

      var start = oldText.slice(0, textarea.selectionStart);

      var newText = start + formattedSelection + end;

      textarea.value = newText;

      console.log(json.id, json.url);
    });

    window.mb.frame.open();
  }
  function formatText(e, format) {
    var selection = window.getSelection();
    if (!selection.toString().trim().length) return;

    var textareas = Array.from(
      selection.anchorNode.querySelectorAll("textarea")
    );
    var textarea = textareas[textareas.length - 1];

    if (!textarea) return;

    var oldText = textarea.value;

    var selectionText = selection.toString();

    var formattedSelection =
      format === "a"
        ? "<" +
          format +
          ' href="">' +
          selection.toString() +
          "</" +
          format +
          ">"
        : "<" + format + ">" + selection.toString() + "</" + format + ">";

    var end = oldText.slice(textarea.selectionEnd, oldText.length);

    var start = oldText.slice(0, textarea.selectionStart);

    var newText = start + formattedSelection + end;

    textarea.value = newText;
  }
})();
