// const clickableRows = document.querySelectorAll('.clickable')

// clickableRows.forEach((rowElement) => {
//   rowElement.addEventListener('click', (e) => {
//     window.location = window.location.href + '/detail/' +rowElement.firstElementChild.textContent
//   })
// })

/* Notify the borrower that is late */
window.onload = () => {
  changeDateColor();
};
function changeDateColor() {
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
}
