tinymce.PluginManager.add('map-embed', (editor) => {
  // Add directions button
  editor.addButton('map-embed', {
    text: '',
    icon: 'map',
    onclick: () => {
      editor.windowManager.open({
        title: 'Add Google Map',
        body: [
          {
            type: 'textbox',
            name: 'address',
            label: 'Address'
          },
          {
            type: 'textbox',
            name: 'width',
            label: 'Map Width',
            value: '600'
          },
          {
            type: 'textbox',
            name: 'height',
            label: 'Map Height',
            value: '400'
          }
        ],
        onsubmit: (e) => {
          const address = e.data.address.replace(/[ ,.]/gi, '+').replace('++', '+');
          const width = e.data.width || 600;
          const height = e.data.height || 400;
          editor.insertContent(`<iframe src="https://www.google.com/maps/embed/v1/place?q=${address}&key=${HPO_CONSTANTS.google_maps_api_key}" width="${width}" height="${height}" frameborder="0" style="border:0" allowfullscreen></iframe>`);
        }
      });
    }
  });
});
