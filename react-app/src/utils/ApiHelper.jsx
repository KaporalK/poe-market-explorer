
import { addPage } from './makeUrl';

async function makeApiCall(url, page) {
  console.log({url, page});
  const urlWithPage = addPage(url, page);
  const response = await fetch(urlWithPage);
  return await response.json();
}

export { makeApiCall };
