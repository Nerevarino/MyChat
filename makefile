classpath = Edronov/Chat/Classes
sidepath = Edronov/Chat/SideEffects
sqlpath = Edronov/Chat/sql
htmlpath = Edronov/Chat/html


MyChat: registration login chat logout  Registration Login Chat Logout PhpPage

registration: $(sidepath)/registration.php
	cp $(sidepath)/registration.php build/
login: $(sidepath)/login.php
	cp $(sidepath)/login.php build/
chat: $(sidepath)/chat.php
	cp $(sidepath)/chat.php build/
logout: $(sidepath)/logout.php
	cp $(sidepath)/logout.php build/

Registration: $(classpath)/Registration.php $(htmlpath)/registration.html $(sqlpath)/registration.sql
	cp $(classpath)/Registration.php build/
	cp $(htmlpath)/registration.html build/
	cp $(sqlpath)/registration.sql build/
Login: $(classpath)/Login.php $(htmlpath)/login.html $(sqlpath)/login.sql
	cp $(classpath)/Login.php build/
	cp $(htmlpath)/login.html build/
	cp $(sqlpath)/login.sql build/
Chat: $(classpath)/Chat.php $(htmlpath)/chat.html $(sqlpath)/getmessages.sql $(sqlpath)/postmessage.sql
	cp $(classpath)/Chat.php build/
	cp $(htmlpath)/chat.html build/
	cp $(sqlpath)/getmessages.sql build/
	cp $(sqlpath)/postmessage.sql build/

Logout: $(classpath)/Logout.php
	cp $(classpath)/Logout.php build/
PhpPage: $(classpath)/PhpPage.php
	cp $(classpath)/PhpPage.php build/


send: MyChat
	scp build/registration.php srv117239@mybeta:~/ttbg.su/registration.php
	scp build/login.php srv117239@mybeta:~/ttbg.su/login.php
	scp build/chat.php srv117239@mybeta:~/ttbg.su/chat.php
	scp build/logout.php srv117239@mybeta:~/ttbg.su/logout.php
	scp build/Registration.php srv117239@mybeta:~/ttbg.su/Registration.php
	scp build/Login.php srv117239@mybeta:~/ttbg.su/Login.php
	scp build/Chat.php srv117239@mybeta:~/ttbg.su/Chat.php
	scp build/Logout.php srv117239@mybeta:~/ttbg.su/Logout.php
	scp build/PhpPage.php srv117239@mybeta:~/ttbg.su/PhpPage.php
	scp build/registration.html srv117239@mybeta:~/ttbg.su/registration.html
	scp build/login.html srv117239@mybeta:~/ttbg.su/login.html
	scp build/chat.html srv117239@mybeta:~/ttbg.su/chat.html
	scp build/getmessages.sql srv117239@mybeta:~/ttbg.su/getmessages.sql
	scp build/login.sql srv117239@mybeta:~/ttbg.su/login.sql
	scp build/postmessage.sql srv117239@mybeta:~/ttbg.su/postmessage.sql
	scp build/registration.sql srv117239@mybeta:~/ttbg.su/registration.sql
