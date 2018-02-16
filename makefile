classpath = Edronov/Chat/Classes
sidepath = Edronov/Chat/SideEffects
sqlpath = Edronov/Chat/sql
htmlpath = Edronov/Chat/html
setuppath = Edronov/Chat/build
buildpath = Edronov/Chat/build/output


MyChat: registration login chat logout  Registration Login Chat Logout PhpPage

registration: $(sidepath)/registration.php
	cp $(sidepath)/registration.php $(buildpath)/
login: $(sidepath)/login.php
	cp $(sidepath)/login.php $(buildpath)/
chat: $(sidepath)/chat.php
	cp $(sidepath)/chat.php $(buildpath)/
logout: $(sidepath)/logout.php
	cp $(sidepath)/logout.php $(buildpath)/

Registration: $(classpath)/Registration.php
	php -f $(setuppath)/Registration.php
Login: $(classpath)/Login.php
	php -f $(setuppath)/Login.php
Chat: $(classpath)/Chat.php
	php -f $(setuppath)/Chat.php
Logout: $(classpath)/Logout.php
	cp $(classpath)/Logout.php $(buildpath)/
PhpPage: $(classpath)/PhpPage.php
	cp $(classpath)/PhpPage.php $(buildpath)/


send: MyChat
	scp $(buildpath)/registration.php srv117239@mybeta:~/ttbg.su/registration.php
	scp $(buildpath)/login.php srv117239@mybeta:~/ttbg.su/login.php
	scp $(buildpath)/chat.php srv117239@mybeta:~/ttbg.su/chat.php
	scp $(buildpath)/logout.php srv117239@mybeta:~/ttbg.su/logout.php
	scp $(buildpath)/Registration.php srv117239@mybeta:~/ttbg.su/Registration.php
	scp $(buildpath)/Login.php srv117239@mybeta:~/ttbg.su/Login.php
	scp $(buildpath)/Chat.php srv117239@mybeta:~/ttbg.su/Chat.php
	scp $(buildpath)/Logout.php srv117239@mybeta:~/ttbg.su/Logout.php
	scp $(buildpath)/PhpPage.php srv117239@mybeta:~/ttbg.su/PhpPage.php
