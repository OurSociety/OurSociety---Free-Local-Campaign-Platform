import 'toastr';

// toastr.options.closeButton = true; // TODO: Fix styling.
toastr.options.preventDuplicates = true;
toastr.options.progressBar = true;

window.flash = {
  push: function (object) {
    let method = object.style;
    if (object.style === 'danger') {
      method = 'error';
    }
    console.log(method);
    toastr[method](object.message);
  }
}
