
async function makeApiCall(url) {
  const response = await fetch(url);
  return await response.json();
}

export { makeApiCall };
