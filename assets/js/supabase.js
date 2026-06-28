const SUPABASE_REST_URL = SUPABASE_URL.replace(/\/+$/, '') + '/rest/v1';

function supabaseHeaders() {
  return {
    apikey: SUPABASE_ANON_KEY,
    Authorization: 'Bearer ' + SUPABASE_ANON_KEY,
    'Content-Type': 'application/json',
    Accept: 'application/json',
    Prefer: 'return=representation',
  };
}

async function supabaseRequest(method, path, body) {
  const res = await fetch(SUPABASE_REST_URL + path, {
    method,
    headers: supabaseHeaders(),
    body: body ? JSON.stringify(body) : undefined,
  });
  if (!res.ok) return null;
  const text = await res.text();
  return text ? JSON.parse(text) : [];
}

function supabaseQuery(table, columns, filters, order) {
  const params = ['select=' + encodeURIComponent(columns || '*')];
  for (const [col, val] of Object.entries(filters || {})) {
    if (val === null) {
      params.push(encodeURIComponent(col) + '=is.null');
    } else {
      params.push(encodeURIComponent(col) + '=eq.' + encodeURIComponent(String(val)));
    }
  }
  if (order) params.push('order=' + order);
  return '/' + table + '?' + params.join('&');
}

async function supabaseSelect(table, columns, filters, order) {
  const path = supabaseQuery(table, columns, filters, order);
  return supabaseRequest('GET', path);
}

async function supabaseSelectOne(table, columns, filters) {
  const result = await supabaseSelect(table, columns, filters);
  return result && result.length > 0 ? result[0] : null;
}

async function supabaseInsert(table, data) {
  return supabaseRequest('POST', '/' + table, data);
}

async function supabaseUpdate(table, data, filters) {
  const params = Object.entries(filters)
    .map(([col, val]) => encodeURIComponent(col) + '=eq.' + encodeURIComponent(String(val)))
    .join('&');
  return supabaseRequest('PATCH', '/' + table + '?' + params, data);
}

async function supabaseDelete(table, filters) {
  const params = Object.entries(filters)
    .map(([col, val]) => encodeURIComponent(col) + '=eq.' + encodeURIComponent(String(val)))
    .join('&');
  return supabaseRequest('DELETE', '/' + table + '?' + params);
}
