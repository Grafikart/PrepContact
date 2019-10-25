class APIError {

  constructor (errors) {
    this.errors = errors.errors
  }

}

export async function post (url, data) {
  const response = await fetch(url, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  })
  const status = response.status
  const result = await response.json()
  if (status >= 200 && status < 300) {
    return result
  } else {
    throw new APIError(result)
  }
}
