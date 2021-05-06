# Library management system PHP
  A web application to manage our faculty’s library where students can borrow books to prepare themselves for the exams.

## The Process of Borrowing Books:
  1. Student have a particular interface to reserve a book before taking it from the library.
  2. To make a reservation student should have a library card.
  3. Student scans their library card through bar-code reader to log in.
  4. Student searches for the book they want. If the book is available they will make a reservation.
  5. After making a reservation the student heads  to the library to finally take the reserved book.
  6. In the library the Administrator makes sure that the student have a reservation if yes he will confirm and give them the book .
## The Process of Adding New Book:
  1. If a book does not exist yet, we add common book’s information and some specific information for each copy of the book.
  2. If a book already registered we add just add the particular information and increment the number of book’s copies.
## The Process of Adding New Students:
   Students already added in an exist DB so our app should access this data.
## The Process of Adding, update Administrators Info:
  1. We add administrators information based on their library cards and they have the same role.
       
## Constraints:
  1. A student can make only one reservation before borrowing the book and can make new one after returning it.
  2. Booked books must be returned before 48 hours, otherwise the administrator will give the student a  warning. After two warnings the student can’t borrow books for one semester.

