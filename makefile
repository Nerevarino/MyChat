class=Edronov/Chat/Classes
sideeffect=Edronov/Chat/SideEffects


MyChat: registration login chat logout  Registration Login Chat Logout PhpPage


registration: $(sideeffect)/registration.php
	scp $(sideeffect)/registration.php srv117239@mybeta:~/ttbg.su/registration.php

login: $(sideeffect)/login.php
	scp $(sideeffect)/login.php srv117239@mybeta:~/ttbg.su/login.php

chat: $(sideeffect)/chat.php
	scp $(sideeffect)/chat.php srv117239@mybeta:~/ttbg.su/chat.php

logout: $(sideeffect)/logout.php
	scp $(sideeffect)/logout.php srv117239@mybeta:~/ttbg.su/logout.php




Registration: $(class)/Registration.php
	scp $(class)/Registration.php srv117239@mybeta:~/ttbg.su/Registration.php

Login: $(class)/Login.php
	scp $(class)/Login.php srv117239@mybeta:~/ttbg.su/Login.php

Chat: $(class)/Chat.php
	scp $(class)/Chat.php srv117239@mybeta:~/ttbg.su/Chat.php

Logout: $(class)/Logout.php
	scp $(class)/Logout.php srv117239@mybeta:~/ttbg.su/Logout.php

PhpPage: $(class)/PhpPage.php
	scp $(class)/PhpPage.php srv117239@mybeta:~/ttbg.su/PhpPage.php