tinymce.PluginManager.add('directions-button', (editor) => {
  // Add directions button
  editor.addButton('directions-button', {
    text: '',
    icon: 'directions',
    onclick: () => {
      editor.windowManager.open({
        title: 'Add Get Directions Button',
        body: [
          {
            type: 'textbox',
            name: 'address',
            label: 'Address'
          }
        ],
        onsubmit: (e) => {
          const address = e.data.address.replace(/[ ,.]/gi, '+');
          editor.insertContent(`<a href="https://www.google.com/maps/dir/Current+Location/${address}/" class="btn btn-primary"><span class="fa fa-compass"></span> Get Directions</a>`, false, true);
        }
      });
    }
  });
});
