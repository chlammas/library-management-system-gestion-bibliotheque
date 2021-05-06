// const clickableRows = document.querySelectorAll('.clickable')

// clickableRows.forEach((rowElement) => {
//   rowElement.addEventListener('click', (e) => {
//     window.location = window.location.href + '/detail/' +rowElement.firstElementChild.textContent
//   })
// })

/* Notify the borrower that is late */
let dueDateElements = document.querySelectorAll('.due-date span');
dueDateElements.forEach((element) => {
  startDate = new Date(element.textContent);
  todayDate = new Date(new Date().toDateString());
  if (startDate - todayDate < 0) {
    setInterval(() => {
      if (element.style.color == 'red') {
        element.style.color = '#212537';
      } else {
        element.style.color = 'red';
      }
    }, 500);
  }
});

// AJAX To Search For a Book
const searchForm = document.querySelector('.search-form');
const queryBox = document.querySelector('.search-form input[name="query"]');
if (searchForm) {
  searchForm.addEventListener('submit', function (event) {
    event.preventDefault();
    makeRequest('borrowers', this.query.value);
  });

  queryBox.addEventListener('keyup', function (event) {
    makeRequest('borrowers', queryBox.value);
  });
}

let httpRequest = new XMLHttpRequest();
function makeRequest(url, query) {
  httpRequest.onreadystatechange = changeContent;
  httpRequest.open('POST', url);
  httpRequest.setRequestHeader(
    'Content-Type',
    'application/x-www-form-urlencoded'
  );
  httpRequest.send('query=' + encodeURIComponent(query));
}

function changeContent() {
  if (httpRequest.readyState === XMLHttpRequest.DONE) {
    if (httpRequest.status === 200) {
      var response = httpRequest.responseText;
      const parser = new DOMParser();

      // Parse the text
      const doc = parser.parseFromString(response, 'text/html');
      const BooksList = document.querySelector('.books-list');
      BooksList.innerHTML = doc.querySelector('.books-list').innerHTML;
    } else {
      alert('There was a problem with the request.');
    }
  }
}

