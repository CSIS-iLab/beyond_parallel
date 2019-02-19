(function() {
  tinymce.PluginManager.add("beyond", function(editor, url) {
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
          height: 300,
          body: [
            {
              type: "textbox",
              multiline: true,
              name: "content",
              style: "height:200px"
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
            console.log(e.data.content);
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
})();
