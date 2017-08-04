function isProbablyMobileAndNonViewport() {
  var appVersion = navigator.appVersion;
  var isAndroid = (/android/gi).test(appVersion);
  var isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
  return (isAndroid || isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent) );
};

// this function is giving domain from provided URL
var oursociety  = {
  nonViewportMessageCount: 0,
  get_iframe_domain : function (url){
    var arr = url.split("/");
    var result = arr[0] + "//" + arr[2];
    return result;
  },
  get_iframe_by_src : function (src){
    var all_iframe = document.getElementsByTagName("iframe");
    var target;
    for(var i = 0, max = all_iframe.length; i < max; i++) {
      if (all_iframe[i].src === src) {
        target = all_iframe[i];
        break;
      }
    }
    return target;
  },
  oursociety_resize : function (event) {
    console.log(event.data);
    if (event.data.destination_iframe == undefined){
      return;
    }
    console.log("message is valid")
    var oursociety_iframe = oursociety.get_iframe_by_src(event.data.destination_iframe);
    if (oursociety_iframe == null || oursociety_iframe == undefined) {
      oursociety_iframe = document.querySelector('iframe[name=oursociety]');
    }
    if (oursociety_iframe != null && oursociety_iframe != undefined) {
      if (isProbablyMobileAndNonViewport()) {
        oursociety_iframe.contentWindow.postMessage('non-viewport', '*');
        console.log('success to send message' + oursociety.nonViewportMessageCount.toString());
        oursociety.nonViewportMessageCount++;
      }
      var oursociety_domain = oursociety.get_iframe_domain(oursociety_iframe.src);
      console.log("domain is valid")
      console.log(event.origin !== oursociety_domain)
      console.log(event.origin);
      console.log(oursociety_domain);
      if (event.origin !== oursociety_domain) {
        return;
      }
      var windowWidth;
      if (oursociety_domain) {
        //console.log(event.data);
        //oursociety_iframe.style.height = (event.data) + "px";
        if(oursociety_iframe && parseInt(event.data.height) > 0) {
          oursociety_iframe.style.height = (event.data.height) + "px";
        }
        windowWidth = window.innerWidth;
        if (windowWidth < 350) {
          oursociety_iframe.style.minWidth = 'initial';
        }
      }
    }
  }
};

// This function resizes the height for "dbox-form-embed" iframe when any message receive
// its also validates if incoming message comes from origin domain then only change height

// this is add event listener to window when any message receive then its call resize method
if (window.addEventListener) {
  window.addEventListener("message", oursociety.oursociety_resize, false);
} else if (window.attachEvent) {
  window.attachEvent("onmessage", oursociety.oursociety_resize);
}

document.writeln(`
    <iframe src="/embed/seth-kaper-dale" height="685px" width="100%" style="max-width: 100%; /*min-width: 780px;*/"
    seamless="seamless" id="oursociety-profile-embed" name="oursociety" frameborder="0"></iframe>
`);
