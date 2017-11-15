import urljoin from 'url-join'

export const API_URL = 'http://localhost:1337/localhost:8000/api'

export default async function apiFetch(endpoint, options = {}) {
  let extraHeaders = {}
  if (
    typeof options.method === 'string' &&
    options.method.toUpperCase() !== 'GET' &&
    options.method.toUpperCase() !== 'HEAD'
  ) {
    extraHeaders['Content-Type'] = 'application/json'
  }
  let resp = await fetch(urljoin(API_URL, endpoint), {
    ...options,
    body:
      options.body ||
      (options.jsonBody ? JSON.stringify(options.jsonBody) : undefined),
    headers: {
      ...extraHeaders,
      ...options.headers
    }
  })
  let data = await resp.json()
  return data
}
