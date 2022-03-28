
function makeUrl(url, filters, page) {
  const filtersString = filters.map((filter) => filter.str).join('&')
  const pageStr = filtersString === '' ? 'page=' + page : '&page=' + page;  
  return url + '?' + filtersString + pageStr;
}

export { makeUrl };
