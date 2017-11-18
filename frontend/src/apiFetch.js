import urljoin from 'url-join'
import ApiError from './errors/ApiError'
export const API_URL =
  process.env.NODE_ENV === 'production'
    ? '/api'
    : 'http://localhost:1337/localhost:8000/api'

export default async function apiFetch(endpoint, options = {}) {
  let extraHeaders = {}
  if (
    typeof options.method === 'string' &&
    options.method.toUpperCase() !== 'GET' &&
    options.method.toUpperCase() !== 'HEAD'
  ) {
    extraHeaders['Content-Type'] = 'application/json'
  }
  if (localStorage.getItem('token') && !options.noAuth) {
    extraHeaders['Authorization'] = `Bearer ${localStorage.getItem('token')}`
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
  if (resp.status > 399) {
    throw new ApiError(data.error || 'Unknown error', resp.status)
  }
  return data
}
