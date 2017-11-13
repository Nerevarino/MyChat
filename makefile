MyChat: makefile index login registration chat dbfail logout post myajax getmes get

index: index.php
	scp index.php srv117239@mybeta:~/ttbg.su/index.php
login: login.php
	scp login.php srv117239@mybeta:~/ttbg.su/login.php
registration: registration.php
	scp registration.php srv117239@mybeta:~/ttbg.su/registration.php
chat: chat.php
	scp chat.php srv117239@mybeta:~/ttbg.su/chat.php
dbfail: dbfail.php
	scp dbfail.php srv117239@mybeta:~/ttbg.su/dbfail.php
logout: logout.php
	scp logout.php srv117239@mybeta:~/ttbg.su/logout.php
post: post.php
	scp post.php srv117239@mybeta:~/ttbg.su/post.php
myajax: myajax.js
	scp myajax.js srv117239@mybeta:~/ttbg.su/myajax.js
getmes: getmes.js
	scp getmes.js srv117239@mybeta:~/ttbg.su/getmes.js
get: get.php
	scp get.php srv117239@mybeta:~/ttbg.su/get.php

