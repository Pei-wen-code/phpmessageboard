# PHP message board
This is a message board [website](https://github.com/Pei-wen-code/phpmessageboard) where users need to login to leave their message. Normal users can also edit and delete their own messages. Admin user has access to admin area where he or she can manage the permission of each user. For example, if users are assigned to the role "banned" by the admin, they will no longer have access to create new posts. When registering and logging, error messages will show for unable to match the username and password, imcomplete fields and when the username has been registered. 

<img width="1438" alt="homepage" src="https://user-images.githubusercontent.com/58638019/131913390-27a54617-cccd-497c-a8a0-5554b54ec9d9.png">

<img width="1433" alt="errorhandle" src="https://user-images.githubusercontent.com/58638019/131913633-b3005b51-b486-48c0-a22b-4661d2906532.png">

# What does this project mean to me?
This project literally advance my knowledge regarding back-end. I gain increadibly a lot from this project. Not only did I learn PHP language and CRUD, but I also learned some bacis knowledge regarding cyber safety. For example, always store hashed password to database and veryfy the hashed password with the password provided by the users when they login. This project also taught me how to prevent XSS attack, using built-in htmlspecialchars method. The most interesting part wehn I was working on this project, is being a hacker try to hack into the database using SQL injection. Therefore, instead of using sprintf method, using prepare statement prevent this kind of attack. Not to mention that I also learned the concept of cookies, the stateless feature of HTTP as well as the use of session to make the server "memorise" who has visited here before. Lastly, this project allowed me to create pagination using limit and offset.

<img width="1437" alt="pagination" src="https://user-images.githubusercontent.com/58638019/131913705-98a486ef-ce4a-4348-8262-30f78a104264.png">
