
function makeUrl(url, filters) {
  let filtersString = null

  if(Object.keys(filters).length > 0) {
    filtersString = Object.entries(filters).map(
        (filter) => filter[1].str
      ).join('&');
  }

  return filtersString !== null ? url + '?' + filtersString : url;
}

function addPage(url, page) {
  return url.includes('?') ? 
    url + '&page=' + page : 
    url + '?page=' + page;  
}

export { makeUrl, addPage };
