const SUPABASE_URL = 'https://seu-projeto.supabase.co';
const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...';

;(function() {
  var scripts = document.getElementsByTagName('script');
  for (var i = 0; i < scripts.length; i++) {
    var s = scripts[i];
    if (!s.src) continue;
    var idx = s.src.indexOf('/assets/js/config.js');
    if (idx !== -1) {
      window.BASE_URL = s.src.substring(0, idx + 1);
      return;
    }
  }
  window.BASE_URL = '/';
})();
