const SUPABASE_URL = 'https://fasilcqydswwkofqokfm.supabase.co';
const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZhc2lsY3F5ZHN3d2tvZnFva2ZtIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODIyMDU4MjksImV4cCI6MjA5Nzc4MTgyOX0.rf73HSGZqahqHs6RSr9YiLMrxnAsMtGL31vLv8R0txI';

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
